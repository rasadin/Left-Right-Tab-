<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Dynamic_Tab extends Widget_Base {

	public function get_name() {
		return 'webalive-dynamic-tab';
	}

	public function get_title() {
		return esc_html__( 'Dynamic Tab', 'webalive-addons-elementor' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
	}
	
	public function get_icon() {
		return 'fa fa-tasks';
	}

    public function get_categories() {
		return [ 'webalive-for-elementor' ];
	}

    protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'webalive-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $this->add_control(
			'value',
			[
				'label' => __( 'Select Left/Right', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 2,	
				'default' => 1,
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'webalive-addons-elementor' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'webalive-addons-elementor' ),
				'placeholder' => __( 'Type your description here', 'webalive-addons-elementor' ),
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Add Images', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Button Text', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Read More' , 'webalive-addons-elementor' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'cta_link', [
				'label' => __( 'Button Link', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'webalive-addons-elementor' ),
				'show_external' => false,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);
		$repeater->add_control(
			'due_date',
			[
				'label' => __( 'Due Date', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
			]
		);
        $this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'webalive-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Title #1', 'webalive-addons-elementor' ),
						'image' => __( 'Item content. Click the edit button to change this text.', 'webalive-addons-elementor' ),
					],
					
				],
				'title_field' => '{{{ title }}}',
			]
		);
		$this->end_controls_section();
        
		/**
		 * Style Tab
		 */
		$this->style_tab();

    }

	private function style_tab() {}
	protected function render() {
		$webalive = $this->get_settings_for_display();
		$due_date = strtotime( $this->get_settings( 'due_date' ) );
		$due_date_in_days = $due_date / DAY_IN_SECONDS;
    ?>
        <!-- Add Markup Starts -->

     <?php if($webalive['value'] == 1): ?>
        <nav>
		     <div class="nav nav-tabs home-tabs" id="nav-tab" role="tablist">
		         <?php foreach (  $webalive['list'] as $key=> $item ) : ?>
			     <a class="nav-item nav-link <?php if($key==0): echo 'active'; endif; ?>" id="nav-home-tab" data-toggle="tab" href="#<?php echo 'tab-'.$key;?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $item['title']; ?></a>
			     <?php endforeach; ?>
		     </div>
		</nav>
		<div class="tab-content home-page-tab" id="nav-tabContent">
		    <?php foreach (  $webalive['list'] as $key=> $item ) : ?>
		        <div class="tab-pane <?php if($key==0): echo 'active'; endif; ?> <?php if($key!=0): echo 'fade'; endif; ?>" id="<?php echo 'tab-'.$key;?>" role="tabpanel" aria-labelledby="nav-home-tab">
                     <div class="container-tab">
		                 <div class="row">
			                 <div class="col-sm-5"> <div class="left-img-tab"> <?php echo '<img src="' . $item['image']['url'] . '">'; ?> </div></div>
			                     <div class="col-sm-7"> 
			                         <div class="right-content-tab"> 
			                             <?php echo $item['due_date']; ?> 
			                             <?php echo $item['item_description']; ?>
			                             <div class = "home-page-tab-btn"><a href="<?php echo esc_url($item['cta_link']['url']); ?>"><?php echo $item['cta_name']; ?></a></div>
			                         </div>
			                     </div>
		                     </div>
		                 </div>
		            </div>
		     <?php endforeach; ?>
        </div>
        
     <?php else : ?>
        <nav>
		     <div class="nav nav-tabs home-tabs" id="nav-tab" role="tablist">
		         <?php foreach (  $webalive['list'] as $key=> $item ) : ?>
			     <a class="nav-item nav-link <?php if($key==0): echo 'active'; endif; ?>" id="nav-home-tab" data-toggle="tab" href="#<?php echo 'tab-'.$key;?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $item['title']; ?></a>
			     <?php endforeach; ?>
		     </div>
		</nav>
		<div class="tab-content home-page-tab" id="nav-tabContent">
		    <?php foreach (  $webalive['list'] as $key=> $item ) : ?>
		        <div class="tab-pane <?php if($key==0): echo 'active'; endif; ?> <?php if($key!=0): echo 'fade'; endif; ?>" id="<?php echo 'tab-'.$key;?>" role="tabpanel" aria-labelledby="nav-home-tab">
                     <div class="container-tab">
		                 <div class="row">
			                 <div class="col-sm-7"> 
                                 <div class="right-content-tab"> 
                                     <?php echo $item['due_date']; ?> 
			                             <?php echo $item['item_description']; ?>
                                             <div class = "home-page-tab-btn">
                                                 <a href="<?php echo esc_url($item['cta_link']['url']); ?>"><?php echo $item['cta_name']; ?></a>
                                             </div>      
                                 </div>
                             </div>
			                     <div class="col-sm-5"> 
			                         <div class="left-img-tab"> 
                                         <?php echo '<img src="' . $item['image']['url'] . '">'; ?> 
			                         </div>
			                     </div>
		                     </div>
		                 </div>
		            </div>
		     <?php endforeach; ?>
		</div>
     <?php endif;  ?>
  <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Dynamic_Tab() );
