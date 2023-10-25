<?php

namespace App\Entity\Trait;

use App\Entity\Media;

trait CacheMediaPathTrait
{
	private string $cacheMediaFolder = "/media/cache/resolve/";
	private string $uploadMediaFolder = "/upload/media/";

	public function getMediaCachePath(?Media $media, ?string $filter = 'middle_banner'): ?string
	{
		if (null === $media) {
			return null;
		}

		$imageName = $media->getImageName();

		return in_array($media->getMimeType(), Media::getFilterableExtensions())
			? $this->cacheMediaFolder . $filter . $this->uploadMediaFolder . $imageName
			: $this->uploadMediaFolder . $imageName;
	}
}