<?php
namespace Instapage\Components\v70\GlobalCountdown;

use Instapage\Models\Component;

class GlobalCountdownModel extends Component
{
    private $dateFormat = 'Y-m-d H:i:s';

    private $timeZone = 'America/Los_Angeles';

    /**
     * Returns date & time set in ACF to which counting should run.
     * When the timer runs out - it adds one week to the date
     * @param  string $dateTime
     * @return array
     * @see    self::$dateFormat
     * @see    self::$timeZone
     */
    private function getTimer(string $dateTime): ?array
    {
        if (empty($dateTime)) {
            return null;
        }
        $timeZone = new \DateTimeZone($this->timeZone);
        $timer = \DateTime::createFromFormat($this->dateFormat, $dateTime, $timeZone);
        $now = new \DateTime('now', $timeZone);
        if ($now >= $timer) {
            $timer->add(\DateInterval::createFromDateString('1 week'));
            update_field('upcoming_webinar', $timer->format($this->dateFormat), $this->contextID);
        }
        return [
            'seconds' => $timer->format('U'),
            'date' => $timer->format('l, F j @ g:iA')
        ];
    }

    /**
     * Customizes Coming soon box
     * @return  array
     */
    public function getUpcoming() : array
    {
        $author = getAcfVar('author', '', $this->contextID);
        $acfDateTime = (string) getAcfVar('upcoming_webinar', '', $this->contextID);

        $upcoming = [
            'showCountdown' => (bool) getAcfVar('show_countdown', '', $this->contextID),
            'timer' => $this->getTimer($acfDateTime),
            'timezone' => getAcfVar('upcoming_webinar_timezone', '', $this->contextID),
            'logo' => getAcfVar('upcoming_webinar_logo', '', $this->contextID),
            'title' => getAcfVar('upcoming_webinar_title', '', $this->contextID),
            'excerpt' => getAcfVar('upcoming_webinar_content', '', $this->contextID),
            'link' => getAcfVar('upcoming_webinar_url', '', $this->contextID),
            'moreText' => getAcfVar('upcoming_webinar_button_text', '', $this->contextID),
            'authorID' => (int) $author->data->ID ?? null,
            'authorName' => $author->data->display_name ?? '',
            'disableLink' => (int) count_user_posts($author->data->ID ?? '') === 0
        ];

        return $upcoming;
    }

    public function getParamsListToInject() : array
    {
        return ['upcoming'];
    }
}
