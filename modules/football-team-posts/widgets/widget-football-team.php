<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Football_Team extends Widget_Base {

	public function get_name() {

		return 'popular-posts';
	}

	public function get_title() {
		return __( 'Football Team Search', 'elementor-custom-widget' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	protected function _register_controls() {


		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Basic', 'elementor-custom-widget' ),
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Heading Text', 'elementor-custom-widget' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'title' => __( 'Enter some text', 'elementor-custom-widget' ),
			]
		);

		// $this->add_control(
		// 	'posts_per_page',
		// 	[
		// 		'label'   => __( 'Number of Posts', 'elementor-custom-widget' ),
		// 		'type'    => Controls_Manager::SELECT,
		// 		'default' => 5,
		// 		'options' => [
		// 			1  => __( 'One', 'elementor-custom-widget' ),
		// 			2  => __( 'Two', 'elementor-custom-widget' ),
		// 			5  => __( 'Five', 'elementor-custom-widget' ),
		// 			10 => __( 'Ten', 'elementor-custom-widget' ),
		// 			-1 => __( 'All', 'elementor-custom-widget' ),

		// 		]
		// 	]
		// );
		$this->end_controls_section();



	}

	protected function render( $instance = [] ) {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		$custom_text = ! empty( $settings['heading_text'] ) ? $settings['heading_text'] : ' Popular Posts ';
		//$post_count = ! empty( $settings['posts_per_page'] ) ? (int)$settings['posts_per_page'] : 1;
		?>
		<h3><?php echo $custom_text; ?></h3>
		<!-- what about the search box for sports team -->
		<div class="search_box">
            <form id = "search_team_form" action="">
                <input type="text" placeholder="Search football team by name..." id="keyword" class="input_search">
				<button type="submit" class="btn btn-success save-btn">Search </button>
            </form><br>
            <div class="search_result" id="datafetch">
				<main class="leaderboard__profiles">
                </main>
            </div>
        </div>
		<?php

	}

	protected function content_template() {}

	public function render_plain_content( $instance = [] ) {}

}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widget_Football_Team() );
