const puppeteer = require('puppeteer');

describe('Challenge Plugin Table', () => {
  let browser;
  let page;

  beforeAll(async () => {
    browser = await puppeteer.launch();
    page = await browser.newPage();
    await page.goto('http://localhost:8889/2023/04/02/hello-world/'); // replace with your test page URL
  });

  afterAll(async () => {
    await browser.close();
  });

  test('Table shows expected results', async () => {
    // Wait for the AJAX call to complete
    await page.waitForResponse(response => response.url().includes('nopriv_challenge_plugin_data'));

    // Get the HTML of the table
    const tableHtml = await page.$eval('#challenge-plugin-table', table => table.outerHTML);

    // Check if the table output matches the expected output
    const expectedOutput = '<table id="challenge-plugin-table"><tbody><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Date</th></tr><tr><td>66</td><td>Chris</td><td>Test</td><td>chris@test.com</td><td>1680592753</td></tr><tr><td>12</td><td>Bob</td><td>Test</td><td>bob@test.com</td><td>1680506353</td></tr><tr><td>33</td><td>Bill</td><td>Test</td><td>bill@test.com</td><td>1681348153</td></tr><tr><td>54</td><td>Jack</td><td>Test</td><td>jack@test.com</td><td>1681802353</td></tr><tr><td>92</td><td>Joe</td><td>Test</td><td>joe@test.com</td><td>1680938353</td></tr></tbody></table>'; // replace with the expected table output
    expect(tableHtml).toEqual(expectedOutput);
  });
});
