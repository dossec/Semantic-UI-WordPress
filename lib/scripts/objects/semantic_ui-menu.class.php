<?php
namespace semantic_ui;

/**
 * This class handles all menus
 */
class menu {
	
	public $ref; // top level class (semantic_ui-main.class.php)
	public $data_class; // the data_class (default: semantic_ui-wp.class.php)
	public $settings;
	
	public function __construct(&$settings,&$ref) {
		$this->ref = &$ref;
		$this->settings = &$settings;
		$this->data_class = &$ref->data_class;
		
	}
	
	
	public function display($menu_id, $options = FALSE) {
		$ref = &$this->ref;
		$settings = &$this->settings;
		$data_class = &$this->data_class;
		
		$defaults = array(
			'id'          => 'menu-%1$s',
			'class'       => '%1$s',
			'item_id'     => 'id-%1$s',
			'item_class'  => '%1$s',
			'before_text' => '',
			'after_text'  => '',
			'before_item' => '',
			'after_item'  => '',
			'no_target'   => FALSE
		);
		
		if ($options) {
			$conf = array_replace_recursive($defaults, $options);
		} else {
			$conf = $defaults;
		}
		
		$the_id = trim(sprintf($conf['id'],str_replace(' ', '-', $menu_id)));
		$the_class = trim(sprintf($conf['class'], "ui blue inverted menu"));
		
		$menu = $data_class->get_menu($menu_id);
		
		$items   = PHP_EOL;
		foreach ($menu as $menu_item) {
			// build attributes
			$classes    = '';
			$id         = $menu_item['ID'];
			$item_id    = trim(sprintf($conf['item_id'], $id));
			$target     = '';
			$text       = '';
			$title      = '';
			$url        = $menu_item['url'];
			
			if (!empty($menu_item['classes']) && is_array($menu_item['classes'])) {
				foreach ($menu_item['classes'] as $class) {
					$class = trim($class);
					if (!empty($class)) {
						$classes .= $class.' ';
					}
				}
				$classes = trim(sprintf($conf['item_class'], trim($classes)));
				
				if (isset($menu_item['children'])) {
					$classes = trim('ui simple dropdown item '.$classes);
				} else {
					$classes = trim('item '.$classes);
				}
				
				$classes = "class=\"$classes\" ";
			}
			
			if (!$conf['no_target'] && !empty($menu_item['target'])) {
				$target = 'target="'.$menu_item['target'].'" ';
			}
			
			if (!empty($menu_item['attr_title'])) {
				$text = $menu_item['attr_title'];
			} elseif (!empty($menu_item['decription'])) {
				$text = $menu_item['description'];
			} elseif (!empty($menu_item['title'])) {
				$text = $menu_item['title'];
			} elseif (!empty($menu_item['post_title'])) {
				$text = $menu_item['post_title'];
			} elseif (!empty($menu_item['post_excerpt'])) {
				$text = $menu_item['post_excerpt'];
			}
			
			if (!empty($menu_item['attr_title'])) {
				$title = 'title="'.esc_attr__($menu_item['attr_title']).'" ';
			} elseif (!empty($menu_item['decription'])) {
				$title = 'title="'.esc_attr__($menu_item['description']).'" ';
			} elseif (!empty($menu_item['post_excerpt'])) {
				$title = 'title="'.esc_attr__($menu_item['post_excerpt']).'" ';
			} elseif (!empty($menu_item['title'])) {
				$title = 'title="'.esc_attr__($menu_item['title']).'" ';
			} elseif (!empty($menu_item['post_title'])) {
				$title = 'title="'.esc_attr__($menu_item['post_title']).'" ';
			}
			
			$children = '';
			
			if (isset($menu_item['children'])) {
				// handle children
			}
			
			// Build item
			if (empty($url) || isset($menu_item['children'])) {
				$fmt = $conf['before_item'].'<div %1$sid="id-%2$s" %3$s%5$s>%4$s%7$s</div>'.$conf['after_item'];
			} else {
				$fmt = $conf['before_item'].'<a %1$sid="id-%2$s" %3$s%5$shref="%6$s">%4$s</a>'.$conf['after_item'];
			}
			$items .= sprintf($fmt,
				$classes,
				$id,
				$target,
				$conf['before_text'].$text.$conf['after_text'],
				$title,
				$url,
				$children
			).PHP_EOL;
			
		}
		
		// now display
		echo "<nav class=\"$the_class\" id=\"$the_id\" role=\"navigation\">$items</nav>".PHP_EOL;
		
	}
	
	
	public function get($menu_id = FALSE) {
		$ref = &$this->ref;
		$settings = &$this->settings;
		
		
		
	}
	
	
}