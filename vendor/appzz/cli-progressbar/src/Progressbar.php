<?php
namespace AppZz\CLI;
use Dariuszp\CliProgressBar;

class Progressbar {

	private $_bar;

	public static $counter = 0;

	public function __construct ($total = 0)
	{
		$this->_total = 0;
		$this->_bar = new CliProgressBar (100);

		if ($total) {
			$this->_total = $total;
		}
	}

	public function start ($text = NULL, $color = 'cyan')
	{
		if ( ! $text) {
			$text = 'Processing';
		}

		if ($this->_total) {
			$this->text (sprintf('%s [%d/%d]', $text, ++Progressbar::$counter, $this->_total), $color);
		} else {
			$this->text (sprintf('%s %d', $text, ++Progressbar::$counter), $color);
		}
	}

	public function end ()
	{
		$this->_bar->setColorToGreen();
		$this->_bar->setProgressTo(100);
		$this->_bar->display();
		$this->_bar->end();
		echo PHP_EOL;
	}

	public function progress ($prc = 0, $random_color = TRUE)
	{
		$prc = intval ($prc);

		if ($random_color) {
			if ($prc > 80)
				$this->_bar->setColorToGreen();
			elseif ($prc > 50)
				$this->_bar->setColorToCyan();
			elseif ($prc > 25)
				$this->_bar->setColorToYellow();
			elseif ($prc >= 0)
				$this->_bar->setColorToRed();
		}

		$this->_bar->setProgressTo($prc);
		$this->_bar->display();

		return $this;
	}

	public function text ($text, $color = 'white', $background_color = NULL)
	{
		echo Utils::color($text, $color, $background_color), PHP_EOL;
	}
}
