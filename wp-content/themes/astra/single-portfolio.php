<?php get_header(); ?>

<main id="primary" class="site-main single-portfolio">

    <?php if (have_posts()) : while (have_posts()) : the_post(); 
        // Get custom fields
        $project_url = get_post_meta(get_the_ID(), '_project_url', true);
        $client_name = get_post_meta(get_the_ID(), '_client_name', true);
        $project_date = get_post_meta(get_the_ID(), '_project_date', true);
    ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="portfolio-header">
            <h1 class="portfolio-title"><?php the_title(); ?></h1>

            <?php if ($client_name || $project_url || $project_date) : ?>
                <div class="portfolio-meta">
                    <?php if ($client_name) : ?>
                        <p><strong>Client:</strong> <?php echo esc_html($client_name); ?></p>
                    <?php endif; ?>

                    <?php if ($project_date) : ?>
                        <p><strong>Project Date:</strong> <?php echo esc_html(date('F j, Y', strtotime($project_date))); ?></p>
                    <?php endif; ?>

                    <?php if ($project_url) : ?>
                        <p><strong>Project URL:</strong> <a href="<?php echo esc_url($project_url); ?>" target="_blank">Visit Project</a></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="portfolio-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="portfolio-content">
            <?php the_content(); ?>
        </div>

        <footer class="portfolio-footer">
            <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="back-link">← Back to Portfolio</a>
        </footer>
    </article>

    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
