<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Image;
use Pizarra\Managers\ImageManager;

class ImageRepo extends BaseRepo
{
	public function getModel()
	{
		return new Image();
	}

	public function getManager($entity, $datos)
	{
		return new ImageManager($entity, $datos);
	}

	public function getTable()
	{
		return 'images';
	}
}