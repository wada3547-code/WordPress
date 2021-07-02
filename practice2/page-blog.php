<?php get_header();?>

<?php
$paged = $_GET['pagenum'];
global $NO_IMAGE_URL;
?>
<body>
<main class="article">
    <div class="mv"></div>
        <div class="breadcrumb">
<?php
breadcrumb( $post->ID );//パンくずリストの表示
?>
    </div>
    <div class="article-section cmn-section">
        <div class="inner">
            <h2 class="cmn-title">
                <p class="main">ブログ</p>
                <span class="sub">blog</span>
            </h2>
            <div class="article-cont">
                <ul class="article-list">

<?php
$query_args = array(
    'post_status'=> 'publish',
    'post_type'=> 'post',
    'order'=>'DESC',
    'posts_per_page'=>10,
    'paged'=>$paged
);
$the_query = new WP_Query( $query_args );
if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
        $title = max_excerpt_length(get_the_title( $post->ID ), 60);//記事タイトルを取得し、文字数を制限（functions.php）
        $desc = get_the_excerpt( $post->ID );//抜粋を取得
        $data = get_the_modified_date( 'Y-m-d', $post->ID );//更新日を取得
        $category = get_the_category( $post->ID )[0]->name;//カテゴリを取得（並び順で1番目にあるものを1つ）
        $link = get_permalink( $post->ID );
?>

<dl class="blog_list">
        <div class=row-image>
            <div class=rowinfo>
                <dd class=row><?php echo $category;?></dd>
            </div>
        <div class="blog_image">
            <img src="<?php echo $thumbnail;?>" alt=""></img>
        </div>
        </div>
            <div class="blog_text1">
            <div class="blog_text">
                <dd><?php echo get_the_date('Y-m-d');?></dd>
            </div>
            <div>
            <dd><a href=<?php echo $link;?> class="blog_title"><?php echo $title;?></a></dd>
            <dt class="blog_text0"><?php echo $desc;?></dt>
            </div>
            </div>
    </dl>

</li>
<?php
endwhile;
endif;
wp_reset_query();
?>
                </ul>
            </div>
            <div class="article-pager">
<?php
$page_url = strtok( $page_url, '?' );//パラメーターは切り捨て
$the_category_id = null;
pagenation($the_query->max_num_pages,$the_category_id,$paged, $page_url);
?>

            </div>
        </div>
    </div>
</main>
</body>

<?php get_footer();?>