<?php

namespace App\Services;

use App\Post;
use App\Comment;

class SynchronizeService
{

	protected $toSync = [
		Post::class => 'https://jsonplaceholder.typicode.com/posts',
		Comment::class => 'https://jsonplaceholder.typicode.com/comments'
	];

	/**
	 * Sync fetched data from Api to Database using CURL
	 */
	public function syncFromApi()
	{
		foreach ($this->toSync as $model => $url) {
			if (! $this->sync($model, $url)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Sync using Curl to fetch
	 * @param  string $model
	 * @param  string $url
	 * @return boolean
	 */
	protected function sync($model, $url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		$output = curl_exec($ch);

		if (!empty($output)) {
			try {
				$toJson = json_decode($output);

				$this->syncToDB($model, $toJson);
			} catch (Exception $e) {
				curl_close($ch);
				return false;
			}
		}

		curl_close($ch);
		return true;
	}

	/**
	 * Sync to Database.
	 * @param  string $modelClass
	 * @param  array  $models
	 * @return void
	 */
	protected function syncToDB($modelClass, array $models)
	{
		// first we clear the existing models.
		$modelClass::truncate();

		$modelClass::unguard(true);

		foreach ($models as $obj) {
			$model = new $modelClass;
			$model->fill((array) $obj);
			$model->save();
		}
		$modelClass::unguard(false);
	}
}