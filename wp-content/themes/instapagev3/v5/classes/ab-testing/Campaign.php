<?php
namespace Instapage\Classes\AbTesting;

/**
 * Class that stores all server-side experiments.
 *
 * Caution! Class is used before initialization of WP, so using WP functions is prohibited here! Use \Instapage\Helpers\PreWpHelper instead.
 */
class Campaign
{
    private $instapageExperiments = [];

    /**
     * Campaign constructor. Add new Experiment instances here.
     * @example Homepage redirect
     * try {
     *   $this->instapageExperiments[] = new Experiment(
     *     'KOq-Ub03RcKyiWbJ_eQVKQ',
     *     '/',
     *     [
     *       new Variation(1, '/home', 0.5),
     *     ],
     *     new \DateTime('2018-11-13'),
     *     30
     *   );
     * } catch (\Exception $e) {
     *   error_log($e->getMessage());
     * }
     * @endexample
     */
    public function __construct()
    {
        // by design we just leaving this empty when no A/B tests,
        // maybe we will improve this in future
    }

    /**
     * Adds necessary JS to the end of HTML document if it's required by the running experiment.
     *
     * @param string $html HTML document content.
     */
    public function applyGoogleOptimizeScripts(&$html)
    {
        foreach ($this->instapageExperiments as $experiment) {
            $experiment->applyGoogleOptimizeScript($html);
        }
    }
}
