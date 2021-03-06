<?php
/*
  Template Name: PrintAll
*/
?>

<?php get_header(); ?>

<?php

global $limit;
global $pages_num;

$pages_num = 0;
$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : null;

function listPages($parent_id, $level)
{
    global $limit;
    global $pages_num;

    if (is_numeric($limit) && ++$pages_num>$limit) return;

    $args = array(
        'post_type' => array( 'page' ),
        'post_status' => array( 'publish' ),
        'orderby' => 'menu_order',
        'order' => 'asc',
        'post_parent' => $parent_id,
        'posts_per_page' => 900,
        'post__not_in' => array( get_the_ID() )
        );
    query_posts( $args );

    $args=array('child_of' => $parent_id, 'parent' => $parent_id, 'sort_column'=>'menu_order', 'exclude'=>get_the_ID());
    $pages = get_pages($args);

    if ($pages)
    {

        foreach ($pages as $page)
        {
            echo '<div class="page" style="margin-bottom:40px;" >';
            echo '    <div class="page-header">';
            echo "        <h$level class='postTitle'>".$page->post_title."</h$level>";
            echo '    </div>';
            echo '    <div class="" >';
            echo $page->post_content;
            echo '    </div>';
            echo '</div>';

            listPages($page->ID, $level);
        }


    }

} ?>

<?php
echo '<div id="content" class="'.CONTAINER_CLASSES.'">';
echo '    <div id="main" class="'.MAIN_CLASSES.'" role="main">';
?>

<?php listPages(0, 1); ?>

<?php
echo '    </div>';
echo '</div>';
?>

<?php get_footer(); ?>
