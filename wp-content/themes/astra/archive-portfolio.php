<?php get_header(); ?>

<main id="primary" class="site-main">
    <h1><?php post_type_archive_title(); ?></h1>

    <?php if (have_posts()) : ?>
        <div class="portfolio-archive portfolio-grid">
            <?php while (have_posts()) : the_post(); 
                // Get custom fields
                $project_url = get_post_meta(get_the_ID(), '_project_url', true);
                $client_name = get_post_meta(get_the_ID(), '_client_name', true);
                $project_date = get_post_meta(get_the_ID(), '_project_date', true);
            ?>
                <article class="portfolio-item">
                    <a href="<?php the_permalink(); ?>">
                    <h2><?php the_title(); ?></h2>

                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>

                    <div class="portfolio-meta">
                        <?php if ($client_name) : ?>
                            <p><strong>Client:</strong> <?php echo esc_html($client_name); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($project_url) : ?>
                            <p><strong>Project URL:</strong> <a href="<?php echo esc_url($project_url); ?>" target="_blank">Click Here</a></p>
                        <?php endif; ?>
                        
                        <?php if ($project_date) : ?>
                            <p><strong>Project Date:</strong> <?php echo esc_html(date('F j, Y', strtotime($project_date))); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </a>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_navigation(); ?>

    <?php else : ?>
        <p>No portfolio items found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
