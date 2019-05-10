<?php



function getVimeoID( $url ) {

	$result = preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/', $url, $matches);

	if ($result) {

        return $matches[5];

    }

    return false;

}



function getYoutubeID( $url ) {

	$pattern = 

        '%^# Match any youtube URL

        (?:https?://)?  # Optional scheme. Either http or https

        (?:www\.)?      # Optional www subdomain

        (?:             # Group host alternatives

          youtu\.be/    # Either youtu.be,

        | youtube\.com  # or youtube.com

          (?:           # Group path alternatives

            /embed/     # Either /embed/

          | /v/         # or /v/

          | /watch\?v=  # or /watch\?v=

          )             # End path alternatives.

        )               # End host alternatives.

        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.

        $%x'

        ;

    $result = preg_match($pattern, $url, $matches);

    if ($result) {

        return $matches[1];

    }

    return false;

}



function getSproutVideoID( $url ){

  $pattern = '/(sproutvideo)/';

  $result = preg_match($pattern, $url, $matches);

  if ($result) {

    return $url;

  }

  return false;

}

function getWistiaVideoID( $url ){
  $pattern = '/(wistia)/';
  $result = preg_match($pattern, $url, $matches);
  if ($result) {
    return $url;
  }
}




function getEmdedVideo( $url, $width = '471', $height = '266' ){

	$vimeo = getVimeoID( $url );

	$youtube = getYoutubeID( $url );

  	$sprout = getSproutVideoID( $url );

  	$wistia = getWistiaVideoID( $url );


  	if ($vimeo) {
  		return '<iframe src="https://player.vimeo.com/video/'.$vimeo.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
  	} elseif ( $youtube ) {
  		return '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$youtube.'" frameborder="0" allowfullscreen></iframe>';
  	} elseif ( $sprout ) {
  		if ( $url === strip_tags($url)) {
	      return '<iframe width="'.$width.'" height="'.$height.'" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
	    } else {
	      $doc = new DOMDocument();
	      $doc->loadHtml($url);
	      $src = $doc->getElementsByTagName('iframe')->item(0)->getAttribute('src');
	      return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'" frameborder="0" allowfullscreen></iframe>';
	    }
  	} elseif ( $wistia ) {
  		echo $url;
  	} else {
  		$doc = new DOMDocument();
	    $doc->loadHtml($url);
	    $src = $doc->getElementsByTagName('iframe')->item(0)->getAttribute('src');
	    return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'" frameborder="0" allowfullscreen></iframe>';
  	}
}



function custom_repeater_data( $repeater_name = null, $fields, $id = null, $option=null ) {

  $data = array();

  $counter = 1;



  if ( ! $repeater_name ) { return false; }



  if( have_rows( $repeater_name, $option ) ) {

    while ( have_rows( $repeater_name , $option) ) : the_row();

      if( $fields ) {

        foreach( $fields as $field_name ) {

          if( $id ) {

            $data[$counter][$field_name] = get_sub_field( $field_name, $id );

          }else {

            $data[$counter][$field_name] = get_sub_field( $field_name );

          }

        }

      }

    $counter++;

    endwhile;

  }

  return $data;

}



add_action( 'init', 'create_posttype' );

function create_posttype() {

	register_post_type( 'videos',

		array(

			'labels' => array(

				'name' => __( 'Videos' ),

				'singular_name' => __( 'Video' )

			),

			'public' => true,

			'has_archive' => false,

			'rewrite' => array('slug' => 'videos'),

			'supports' => array( 'title', 'editor' )

		)

	);

}





function update_videos( $post_id ) {

  // If this is just a revision, don't send the email.

  if ( wp_is_post_revision( $post_id ) )

    return;



  $content_post = get_post($post_id);

  $content = $content_post->post_content;

  $thepost_title = $content_post->post_title;

  $thepost_date = $content_post->post_date;



  if ( in_array($content_post->post_type, array('post','page','product')) ) {

      switch ($content_post->post_type) {

        case 'product':

          

          $videos = custom_repeater_data('videos', array('embed_videos'), $post_id);

          $urls = array();

          foreach ($videos as $video) {

            preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $video['embed_videos'], $video_matches);

            if ( !$video_matches[1] ) preg_match_all("/<iframe.*src=\'(.*)\'.*><\/iframe>/isU", $video['embed_videos'], $video_matches);

            if ( $video_matches[1] ) {

              $urls[] = $video_matches[1][0];

            }

          }

          // preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches);

          break;

        

        default:

          preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches);

          if ( !$matches[1] ) preg_match_all("/<iframe.*src=\'(.*)\'.*><\/iframe>/isU", $content, $matches);

          $urls = $matches[1];

          break;

      }



      $videos = get_posts(array(

        'fields' => 'ids',

        'post_type' => 'videos',

        'meta_query' => array(

            array(

               'key' => 'post',

               'value' => $post_id,

               'compare' => 'LIKE'

            )

         )

      ));



      if ( $videos ) {

        foreach ( $videos as $video ) :

          wp_delete_post($video,true);

        endforeach;

      }

      wp_reset_postdata();



      $ctr_vids = 1;

      foreach ($urls as $url) {

        $addition_title = $content_post->post_type == 'product' ? ' Testimonial '.$ctr_vids : '';

        $my_post = array(

          'post_title'    => wp_strip_all_tags( $thepost_title ).$addition_title,

          'post_date'     => $thepost_date,

          'post_status'   => 'publish',

          'post_type'     => 'videos'

        );

         

        // Insert the post into the database

        $thisID = wp_insert_post( $my_post );

        if ( $thisID ) {

          update_post_meta( $thisID, 'choose_option', ( getSproutVideoID($url) ? 'embedsrc' : 'videourl' ) );

          update_post_meta( $thisID, '_choose_option', 'field_5a4def484ffa0' );

          update_post_meta( $thisID, 'video', $url );

          update_post_meta( $thisID, '_video', 'field_594392923e490' );

          update_post_meta( $thisID, 'embed', getEmdedVideo($url) );

          update_post_meta( $thisID, '_embed', 'field_5a4def234ff9f' );

          update_post_meta( $thisID, 'post', $post_id );

          update_post_meta( $thisID, '_post', 'field_5943962c3e491' );

        }



        $ctr_vids++;

      }

  }

}

add_action( 'save_post', 'update_videos' );