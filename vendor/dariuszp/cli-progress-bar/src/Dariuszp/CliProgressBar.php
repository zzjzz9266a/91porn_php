<?php

namespace Dariuszp;

/**
 * Class CliProgressBar
 * @package Dariuszp
 */
class CliProgressBar
{
    const COLOR_CODE_FORMAT = "\033[%dm";

    /**
     * @var int
     */
    protected $barLength = 40;

    /**
     * @var array|bool
     */
    protected $color = false;

    /**
     * @var int
     */
    protected $steps = 100;

    /**
     * @var int
     */
    protected $currentStep = 0;

    /**
     * @var string
     */
    protected $charEmpty = '░';

    /**
     * @var string
     */
    protected $charFull = '▓';
    /**
     * @var string
     */
    protected $defaultCharEmpty = '░';

    /**
     * @var string
     */
    protected $defaultCharFull = '▓';

    /**
     * @var string
     */
    protected $alternateCharEmpty = '_';

    /**
     * @var string
     */
    protected $alternateCharFull = 'X';

    public function __construct($steps = 100, $currentStep = 0, $forceDefaultProgressBar = false)
    {
        $this->setSteps($steps);
        $this->setProgressTo($currentStep);

        // Windows terminal is unable to display utf characters and colors
        if (!$forceDefaultProgressBar && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->displayDefaultProgressBar();
        }
    }

    /**
     * @param int $currentStep
     * @return $this
     */
    public function setProgressTo($currentStep)
    {
        $this->setCurrentstep($currentStep);
        return $this;
    }

    /**
     * @return $this
     */
    public function displayDefaultProgressBar()
    {
        $this->charEmpty = $this->defaultCharEmpty;
        $this->charFull = $this->defaultCharFull;
        return $this;
    }

    /**
     * @return $this
     */
    public function setColorToDefault()
    {
        $this->color = false;
        return $this;
    }

    public function setColorToBlack()
    {
        return $this->setColor(30, 39);
    }

    /**
     * @param $start
     * @param $end
     * @return $this
     */
    protected function setColor($start, $end)
    {
        $this->color = array(
            sprintf(self::COLOR_CODE_FORMAT, $start),
            sprintf(self::COLOR_CODE_FORMAT, $end),
        );
        return $this;
    }

    public function setColorToRed()
    {
        return $this->setColor(31, 39);
    }

    public function setColorToGreen()
    {
        return $this->setColor(32, 39);
    }

    public function setColorToYellow()
    {
        return $this->setColor(33, 39);
    }

    public function setColorToBlue()
    {
        return $this->setColor(34, 39);
    }

    public function setColorToMagenta()
    {
        return $this->setColor(35, 39);
    }

    public function setColorToCyan()
    {
        return $this->setColor(36, 39);
    }

    public function setColorToWhite()
    {
        return $this->setColor(37, 39);
    }

    /**
     * @return string
     */
    public function getDefaultCharEmpty()
    {
        return $this->defaultCharEmpty;
    }

    /**
     * @param string $defaultCharEmpty
     */
    public function setDefaultCharEmpty($defaultCharEmpty)
    {
        $this->defaultCharEmpty = $defaultCharEmpty;
    }

    /**
     * @return string
     */
    public function getDefaultCharFull()
    {
        return $this->defaultCharFull;
    }

    /**
     * @param string $defaultCharFull
     */
    public function setDefaultCharFull($defaultCharFull)
    {
        $this->defaultCharFull = $defaultCharFull;
    }

    /**
     * @return $this
     */
    public function displayAlternateProgressBar()
    {
        $this->charEmpty = $this->alternateCharEmpty;
        $this->charFull = $this->alternateCharFull;
        return $this;
    }

    /**
     * @param int $currentStep
     * @return $this
     */
    public function addCurrentStep($currentStep)
    {
        $this->currentStep += intval($currentStep);
        return $this;
    }

    /**
     * @return string
     */
    public function getCharEmpty()
    {
        return $this->charEmpty;
    }

    /**
     * @param string $charEmpty
     * @return $this
     */
    public function setCharEmpty($charEmpty)
    {
        $this->charEmpty = $charEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharFull()
    {
        return $this->charFull;
    }

    /**
     * @param string $charFull
     * @return $this
     */
    public function setCharFull($charFull)
    {
        $this->charFull = $charFull;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateCharEmpty()
    {
        return $this->alternateCharEmpty;
    }

    /**
     * @param string $alternateCharEmpty
     * @return $this
     */
    public function setAlternateCharEmpty($alternateCharEmpty)
    {
        $this->alternateCharEmpty = $alternateCharEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateCharFull()
    {
        return $this->alternateCharFull;
    }

    /**
     * @param string $alternateCharFull
     * @return $this
     */
    public function setAlternateCharFull($alternateCharFull)
    {
        $this->alternateCharFull = $alternateCharFull;
        return $this;
    }

    /**
     * @param int $step
     * @param bool $display
     * @return $this
     */
    public function progress($step = 1, $display = true)
    {
        $step = intval($step);
        $this->setCurrentstep($this->getCurrentStep() + $step);

        if ($display) {
            $this->display();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentStep()
    {
        return $this->currentStep;
    }

    /**
     * @param int $currentStep
     * @return $this
     */
    public function setCurrentStep($currentStep)
    {
        $currentStep = intval($currentStep);
        if ($currentStep < 0) {
            throw new \InvalidArgumentException('Current step must be 0 or above');
        }

        $this->currentStep = $currentStep;
        if ($this->currentStep > $this->getSteps()) {
            $this->currentStep = $this->getSteps();
        }
        return $this;
    }

    public function display()
    {
        print $this->draw();
    }

    /**
     * @return string
     */
    public function draw()
    {
        $fullValue = floor($this->getCurrentStep() / $this->getSteps() * $this->getBarLength());
        $emptyValue = $this->getBarLength() - $fullValue;
        $prc = number_format(($this->getCurrentStep() / $this->getSteps()) * 100, 1, '.', ' ');

        $colorStart = '';
        $colorEnd = '';
        if ($this->color) {
            $colorStart = $this->color[0];
            $colorEnd = $this->color[1];
        }

        $bar = sprintf("%4\$s%5\$s %3\$.1f%% (%1\$d/%2\$d)", $this->getCurrentStep(), $this->getSteps(), $prc, str_repeat($this->charFull, $fullValue), str_repeat($this->charEmpty, $emptyValue));
        return sprintf("\r%s%s%s", $colorStart, $bar, $colorEnd);
    }

    /**
     * @return int
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @param int $steps
     * @return $this
     */
    public function setSteps($steps)
    {
        $steps = intval($steps);
        if ($steps < 0) {
            throw new \InvalidArgumentException('Steps amount must be 0 or above');
        }

        $this->steps = intval($steps);

        $this->setCurrentStep($this->getCurrentStep());

        return $this;
    }

    /**
     * @return int
     */
    public function getBarLength()
    {
        return $this->barLength;
    }

    /**
     * @param $barLength
     * @return $this
     */
    public function setBarLength($barLength)
    {
        $barLength = intval($barLength);
        if ($barLength < 1) {
            throw new \InvalidArgumentException('Progress bar length must be above 0');
        }
        $this->barLength = $barLength;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->draw();
    }

    /**
     * Alias to new line (nl)
     */
    public function end()
    {
        $this->nl();
    }

    /**
     * display new line
     */
    public function nl()
    {
        print "\n";
    }
}