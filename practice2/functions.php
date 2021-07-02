<?php


global $NO_IMAGE_URL;

$NO_IMAGE_URL='/image/blog-image/list-img1.png';

add_theme_support('post-thumbnails');



/*文字数の設定*/

function max_excerpt_length( $string, $maxLength){
    $length = mb_strlen($string, 'UTF-8');
    if($length < $maxLength){
    return $string;
    }else{
        $string = mb_substr( $string , 0 , $maxLength, 'utf-8');
        return $string. '[...]';
    }
}

//ページネーション
function pagenation($pages, $item_id, $paged,$page_url, $range = 2){

    $pages = (int) $pages;
    $paged = $paged ?: 1;
    $term_id = ($term_id) ? $term_id : 0;
    $s = $_GET['s'];
    $search = ($s) ? '&s='.$s : '';
    
    if($pages === 1){
        //1ページ以上の時は出力しない
        return;
    
    };
    
    if(1 !== $pages ){
        //2ページ以上の時
        echo '<div class="page-inner">';
        if($paged > $range +1 ){
    echo'<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum=1'.$search.'"><span>1</span></a></div>';
    echo'<div class="dots"><span>・・・</span></div>';
    };
    for($i = 1; $i<= $pages; $i++){
        //ページの開示
        if($i <= $paged + $range && $i >= $paged - $range ){
            if($paged == $i) {
    //現在表示しているページ
    echo '<div class="number-current"><span>'.$i.'</span></div>';
    } else {
        //前後のページ
        echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$i.$search.'"><span>'.$i.'</span></a></div>';
        };
    };
    };
    if( $paged < $pages - $range ){
        echo '<div class="dots"><span>・・・</span></div>';
        echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$pages.$search.'"><span>'. $pages.'</span></a></div>';
    }
    echo '</div>';
    };
    };



//サイドバー
register_sidebar();



//標準機能
function my_setup(){
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5',array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme','my_setup');

//CSS・JS
function my_script_init(){
    wp_enqueue_style('reset-name',get_template_directory_uri() .'/reset.css', array(), '1.0.0' , 'all' );
    wp_enqueue_style('style-name',get_template_directory_uri() .'/style.css', array(), '1.0.0' , 'all' );
if(is_single()){
    wp_enqueue_style('blog-name',get_template_directory_uri() .'/blog.css', array(), '1.0.0' , 'all' );
}
}
add_action('wp_enqueue_scripts' , 'my_script_init');




//パンくず

function breadcrumb($postID){
    $title = get_the_title($postID);
if(is_single()){
//詳細ページの場合
echo'<ul class="breadcrumb_ul">';
    echo'<li class="breadcrumb_list"><a href="/">ホーム</a></li>';
    echo'<li class="breadcrumb_list"><a href="/blog/">ブログ一覧</a></li>';
    echo'<li class="breadcrumb_list"><a href="#">カテゴリー</a></li>';
    echo'<li class="breadcrumb_list" aria-current="page">'.$title.'</li>';
echo'</ul>';
}
else if( is_page()){
//固定ページの場合
echo'<ul class="breadcrumb_ul">';
echo '<li class="breadcrumb_list"><a href="/">ホーム</a></li>';
echo '<li class="breadcrumb_list"aria-current="page">'.$title.'</li>';
echo"</ul>";
}
}

