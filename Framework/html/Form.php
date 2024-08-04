<?php 
namespace Framework\html;
defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * html Form genarator
 */
class Form{

	static function bootstrap_field_error($name){
		?>

          <?php if (get_error($name)): ?>                        
            <div class="invalid-feedback ml-3 d-block">
            <?php echo get_error($name); ?>
            </div>
          <?php endif ?>


		<?php
	}

	static function file($name, $attr = []){
		if (empty($attr['id']) === true) {
			$attr['id'] = $name;
		}
		$attr = self::attr($attr);
		echo '<input type="file" '.$attr.' name="'.$name.'">';
	}

	static function text($name, $value = '',$attr = []){
		if (empty($attr['id']) === true) {
			$attr['id'] = $name;
		}
		$attr = self::attr($attr);
		echo '<input type="text" '.$attr.' value="'.$value.'" name="'.$name.'">';
	}

	static function textarea($name, $value = '',$attr = []){
		if (empty($attr['id']) === true) {
			$attr['id'] = $name;
		}
		$attr = self::attr($attr);
		echo '<textarea name="'.$name.'" '.$attr.' >'.$value.'</textarea>';
		?>
		<?php
	}

	static function number($name, $value = '',$attr = []){
		if (empty($attr['id']) === true) {
			$attr['id'] = $name;
		}
		$attr = self::attr($attr);
		echo '<input type="number" '.$attr.' value="'.$value.'" name="'.$name.'">';
	}

	
	static function hidden($name, $value){
		echo '<input type="hidden"  value="'.$value.'" name="'.$name.'">';
	}

	static function email($name, $value = '',$attr = []){
		if (empty($attr['id']) === true) {
			$attr['id'] = $name;
		}
		$attr = self::attr($attr);
		echo '<input type="email" '.$attr.' value="'.$value.'" name="'.$name.'">';
	}

	static function password($name, $attr = []){
		if (empty($attr['id']) === true) {
			$attr['id'] = $name;
		}
		$attr = self::attr($attr);
		echo '<input type="password" '.$attr.' name="'.$name.'">';
	}

	static function checkbox($name, $checked = false, $attr = []){
		$attr = self::attr($attr);
		echo '<input type="checkbox" '.$attr.' name="'.$name.'" '.$checked.' >';
	}
	
	static function label($for, $text, $attr = []){
		$attr = self::attr($attr);
		echo '<label '.$attr.' for="'.$for.'">'.__($text).'</label>';
	}

	static function button($text, $attr = []){
		$attr = self::attr($attr);
		echo '<button '.$attr.' type="submit">'.$text.'</button>';

	}
	static function patch($action, $attr = []){
		self::post($action, $attr);
		self::method('PATCH');

	}
	static function put($action, $attr = []){
		self::post($action, $attr);
		self::method('PUT');
	}
	static function delete($action, $attr = []){
		self::post($action, $attr);
		self::method('delete');
	}

	static function post($action, $attr = []){
		self::f($action, 'POST', $attr);
		self::csrf();
	}

	static function upload($action, $attr = []){
		$attr['enctype'] = 'multipart/form-data';
		self::post($action, $attr);
		self::method('PUT');
	}

	static function get($action, $attr = []){
		self::f($action, 'get', $attr);
		self::csrf();
	}
	static function close(){
		echo '</form>';
	}

	static function method($m){
		echo '<input type="hidden" name="request_method" value="'.$m.'">';
	}
	static function csrf(){
		echo '<input type="hidden" name="csrf_token" value="'.csrf_token('csrf_token').'">';
	}

	static function f($action, $method, $attr = []){
		$attr = self::attr($attr);
		echo '<form action="'.$action.'" method="'.$method.'" '.$attr.'>';
	}


	static function select($name, $options, $value, $multiple = false, $attr = []){
		$attr = self::attr($attr);
		?>
		<select name="<?php echo $name; ?><?php echo ($multiple === true) ? '[]' : '' ; ?>" id="<?php echo $name; ?>" <?php echo ($multiple === true) ? 'multiple="multiple"' : '' ; ?> <?php echo $attr; ?>>			
			<?php foreach ($options as $key => $val): ?>
				<option value="<?php echo $key; ?>"

						<?php if ($multiple === true): ?>

							<?php if (empty($value) === false): ?>								
								<?php foreach ($value as $k => $v): ?>
									<?php echo 	($key == $v) ? 'selected' : '' ; ?>
								<?php endforeach ?>							
							<?php endif ?>

						<?php else: ?>
							<?php echo ($key == $value) ? 'selected' : '' ; ?>
						<?php endif ?>

					><?php echo $val; ?></option>
			<?php endforeach ?>
		</select>
		<?php	
	}

	static function attr($attr){
		$data = '';
		if (count($attr) > 0) {
			foreach ($attr as $key => $value) {
				$data .= ' '.$key.'="'.$value.'" ';
			}
		}
		return $data;
	}
}
?>
