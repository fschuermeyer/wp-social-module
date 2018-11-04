<?php

/**
 *  Refactor Social Share as Class
 *  by Felix Schürmeyer
 *  Social Share v 1.5
 * 
 *  Needs PHP 7 for Type Hint
 */

class SocialShareWordpress
{

    private $currentUrl;
    private $text;
    private $mediaUrl;

    /**
     *  Defined Parameters
     *  - current Url
     *  - text
     *  - media Url
     */

    public function __construct(string $currentUrl, string $text, string $mediaUrl)
    {
        $this->currentUrl = urlencode($currentUrl);
        $this->text = rawurlencode($text);
        $this->mediaUrl = urlencode($mediaUrl);
    }

    public function getSocialNavi(): string
    {

        $social_medias = [
            'facebook' => 'http://www.facebook.com/sharer.php?u=' . $this->currentUrl,
            'twitter' => 'https://twitter.com/intent/tweet?url=' . $this->currentUrl . '&text=' . $this->text,
            'pintrest' => 'http://pinterest.com/pin/create/link/?url=' . $this->currentUrl . '&media=' . $this->mediaUrl . '&description=' . $this->text,
            'whatsapp' => 'https://api.whatsapp.com/send?text=' . $this->currentUrl . '%20' . $this->text,
            'google' => 'https://plus.google.com/share?url=' . $this->currentUrl,
            'mail' => 'mailto:?body=' . $this->currentUrl . '&subject=' . $this->text,
        ];


        $content = '<ul class="social_share_fs">';

        foreach($social_medias as $social => $link){
            $content .= '<li class="' . $social . '"><a class="not-show" href="' . $link . '"><span class="icon ' . $social . '">' . ucwords($social) . '</span></a></li>';
        }

        $content .= '</ul>';

        return $content;
    }

}

// Integration in Wordpress
function social_share($content)
{
    global $wp;
 
    if (is_single()) {

        
        $social = new SocialShareWordpress(
            home_url(add_query_arg(array(),$wp->request)), 
            get_the_title(),
            get_the_post_thumbnail_url()
        );
        
        $navi = $social->getSocialNavi();

        $formatContent = $navi;
        $formatContent .= $content;
        return $formatContent;
    } else {
        return $content;
    }
}

add_filter('the_content', 'social_share');








/*
    Wordpress Dummy Functions
    Remove if you are use this Module, its Only for Testing.
 */

function add_filter($pa1, $pa2)
{
    $content = 'This is the Main Content <br>';
    echo $pa2($content);
}
function is_single()
{
    return true;
}