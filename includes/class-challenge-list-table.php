<?php
/**
 * WP List Table class for displaying Challenge Plugin data in the WordPress admin.
 *
 * @package ChallengePlugin
 */

namespace ChallengePlugin;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * WP List Table class for displaying Challenge Plugin data in the WordPress admin.
 */
class Challenge_List_Table extends \WP_List_Table {

    /**
     * The data to display in the table.
     *
     * @var array
     */
    protected $data = array();

    /**
     * The headers to display in the table.
     *
     * @var array
     */
    protected $headers = array();    

    /**
     * The title to display in the table.
     *
     * @var array
     */
    protected $title = '';    

    /**
     * Set up the list table.
     */
    public function __construct() {
        parent::__construct( array(
            'singular' => __( 'Challenge', 'challenge-plugin' ),
            'plural'   => __( 'Challenges', 'challenge-plugin' ),
            'ajax'     => false,
        ) );        
    }

    /**
     * Set the data to display in the table.
     *
     * @param array $data The data to display.
     */
    public function set_data( $data ) {
        $this->data = $data;
    }

    /**
     * Define the columns for the table.
     *
     * @return array The columns for the table.
     */
    public function get_columns() {
        $headers_array=array();
        foreach( $this->headers as $header ) {
            $headers_array[$header] = __( $header, 'challenge-plugin' );
        }

        return $headers_array;
    }

    /**
     * Define the sortable columns for the table.
     *
     * @return array The sortable columns for the table.
     */
    public function get_sortable_columns() {
        return array(
            'ID'      => array( 'id', false ),
            'Email'      => array( 'fname', false ),
            'First Name'      => array( 'email', false ),
            'Date' => array( 'date', 'asc' ),
        );
    }

    /**
     * Define the default column values.
     *
     * @param array  $item        The current item.
     * @param string $column_name The current column.
     * @return mixed The default column value.
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'Date':
                return wp_date( get_option( 'date_format' ), $item->date );
                break;
            default:
                $variable_name = explode( ' ', $column_name);
                if ( count( $variable_name ) == 1 )  {
                    $variable_name = strtolower($variable_name[0]);
                } else {
                    $variable_name = strtolower($variable_name[0][0] . $variable_name[1]);
                }
                return $item->$variable_name;
        }
    }

    /**
     * Define the title column value.
     *
     * @param array $item The current item.
     * @return string The title column value.
     */
    protected function column_id( $item ) {
        $actions = array(
            'edit'   => sprintf( '<a href="%s">%s</a>', '#', __( 'Edit', 'challenge-plugin' ) ),
            'delete' => sprintf( '<a href="%s">%s</a>', '#', __( 'Delete', 'challenge-plugin' ) ),
        );

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s',
            '#',
            $item->id,
            $this->row_actions( $actions )
        );
    }    

    	/**
	 * Return sorted array
	 *
	 * @param array $a Current table element to sort.
	 * @param array $b Next table element to sort.
	 * @return string Sort order
	 */
	public function usort_reorder( $a, $b ) {
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : 'date';
		$orderby = ( isset( $a->$orderby ) && isset( $b->$orderby ) ) ? $orderby : 'date';

		// If no order, default to asc.
		$order = ( ! empty( $_GET['order'] ) ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : 'desc';

		// Determine sort order.
		$result = strnatcasecmp( (string) $b->$orderby, (string) $a->$orderby );

		// Send final sort direction to usort.
		return ( 'desc' === $order ) ? $result : -$result;
	}

        /**
         * Prepare the data for display in the table.
         */
        public function prepare_items() {
            $data = $this->get_data();
            $this->set_data( (array) $data->data->rows );

            $this->headers = $data->data->headers;

            $this->title = $data->title;

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns(); 
            usort( $this->data, array( &$this, 'usort_reorder' ) );          

            $this->_column_headers = array( $columns, $hidden, $sortable );

            $per_page = 20;
            $current_page = $this->get_pagenum();
            $total_items = count( $this->data );

            // Create the pagination.
            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
            ) );

            // Slice the data array to show only the items for the current page.
            $data = array_slice( $this->data, ( $current_page - 1 ) * $per_page, $per_page );

            // Set the items to be displayed in the table.
            $this->items = $this->data;
        }     

        private function get_data() {
            $handler = new Ajax_Handler(true);
            $data = $handler->get_data(true);

            return $data;
        }         
}