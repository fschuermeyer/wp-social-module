<?php 
/* Social Share Module v 1
by Felix Schürmeyer */





function url_gen(){

    global $wp;  
    $current_url = home_url(add_query_arg(array(),$wp->request));
    $url = urlencode($current_url);
    $text = rawurlencode(get_the_title());
    $media_url = urlencode(get_the_post_thumbnail_url());

        $social_medias = array(
            'facebook' => 'http://www.facebook.com/sharer.php?u='.$url,
            'twitter'  => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $text,
            'pintrest' => 'http://pinterest.com/pin/create/link/?url='. $url .'&media='. $media_url .'&description='. $text,
            'whatsapp' => 'https://api.whatsapp.com/send?text='.$url .'%20'. $text,
            'google'   => 'https://plus.google.com/share?url='.$url,
            'mail'     => 'mailto:?body='.$url.'&subject='.$text,
        );

    $var = array_keys($social_medias);

    $content .= '<ul class="social_share_fs">';
        foreach($var as $entry){
            $url_social = $social_medias[$entry];        
            $content .= '<li class="'.$entry.'"><a class="not-show" href="'.$url_social.'"><span class="icon '.$entry.'">'.$entry.'</span></a></li>';
        }
    $content .= '</ul>';


    return $content;
}

// Integration in thme
function social_share( $content ) {
    if(is_single()){
    $content_new .= url_gen();
    $content_new .= $content;
    return $content_new;
    
    }else{
        return $content;
    }
}


    add_filter( 'the_content', 'social_share' );
