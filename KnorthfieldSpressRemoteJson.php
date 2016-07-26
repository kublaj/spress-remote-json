<?php

use Yosymfony\Spress\Core\Plugin\PluginInterface;
use Yosymfony\Spress\Core\Plugin\EventSubscriber;
use Yosymfony\Spress\Core\Plugin\Event\EnvironmentEvent;

class KnorthfieldSpressRemoteJson implements PluginInterface
{
	private $io;

	public function initialize(EventSubscriber $subscriber)
	{
		$subscriber->addEventListener('spress.start', 'onStart');
	}

	public function getMetas()
	{
		return [
			'name' => 'knorthfield/spress-remote-json',
			'description' => 'Spress plugin to add remote_json() function to Twig templates',
			'author' => 'Kris Northfield',
			'license' => 'MIT',
		];
	}

	public function onStart(EnvironmentEvent $event)
	{

		$renderizer = $event->getRenderizer();
		$renderizer->addTwigFunction('remote_json', function($url){
			
			if (!file_exists('.cache')) {
			    mkdir('.cache');
			}
			
			$cache_file = '.cache/' . sha1($url);
			
			if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 5 ))) {
				$json = file_get_contents($cache_file);
			} else {
				$json = file_get_contents($url);
				file_put_contents($cache_file, $json, LOCK_EX);
			}
			
			return json_decode($json);

		});

	}
}
