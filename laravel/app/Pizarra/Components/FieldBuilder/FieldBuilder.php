<?php namespace Pizarra\Components\FieldBuilder;

class FieldBuilder {

	protected $defaultClasses = [
		// 'checkbox' => '',
		// 'password' => '',
		// 'select'   => '',
		// 'text'     => ''
	];

	public function getDefaultClass($type)
	{
		if (isset ($this->defaultClasses[$type]))
		{
			return $this->defaultClasses[$type];
		}

		return '';
	}

	public function buildCssClasses($type, &$attributes)
	{
		$defaultClass = $this->getDefaultClass($type);

		if (isset ($attributes['input']['class']))
		{
			$attributes['input']['class'] = $attributes['input']['class']. ' '. $defaultClass;
		}
		else
		{
			$attributes['input']['class'] = $defaultClass;
		}
	}

	public function buildLabel($name, $attributes)
	{
		if (\Lang::has('validation.attributes.' . $name))
		{
			$label = \Lang::get('validation.attributes.' . $name);
		}
		else
		{
			$label = str_replace('_', ' ', $name);
		}

		$label = ucfirst($label);

		if (isset ($attributes['label']))
		{			
			return \Form::label($name, $label, $attributes['label']);
		}

		return \Form::label($name, $label);
	}


	public function buildControls($type, $name, $value = null, $attributes = array(), $options = array())
	{
		switch ($type) 
		{
			case 'select':
				return \Form::select($name, $options, $value, $attributes['input']);
			case 'password':
				return \Form::password($name, $attributes['input']);
			case 'checkbox':
				return \Form::checkbox($name);
			default:
				return \Form::input($type, $name, $value, $attributes['input']);
		}
	}

	public function buildTemplate($type)
	{
		if (\File::exists('app/views/fields/' . $type . '.blade.php'))
		{
			return 'fields/' . $type;
		}

		return 'fields/field';
	}

	public function buildErrors($name)
	{
		$error = null;

		if (\Session::has('errors'))
		{
			$errors = \Session::get('errors');
			
			if ($errors->has($name))
			{
				$error = $errors->first($name);
			}
		}

		return $error;
	}

	public function input($type, $name, $value = null, $attributes = array(), $options = array())
	{
		$this->buildCssClasses($type, $attributes);
		$label    = $this->buildLabel($name, $attributes);
		$controls = $this->buildControls($type, $name, $value, $attributes, $options);
		$errors   = $this->buildErrors($name);
		$template = $this->buildTemplate($type);

		return \View::make($template, compact('label', 'controls', 'errors'));
	}

	public function password($name, $attributes)
	{
		return $this->input('password', $name, null, $attributes);
	}

	public function __call($method, $params)
	{
		array_unshift($params, $method);
		return call_user_func_array([$this, 'input'], $params);
	}

}