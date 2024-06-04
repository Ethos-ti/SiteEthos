<?php get_header();

$home_url = '/home';
$contact_url = '/contato/';
?>
<div class=" container container--narrow error-404">
    <h1 class="post-header post-header__title">404</h1>
    <span class="not-found">pagina não encontrada</span>
    <div class="content">
        <p>Parece que essa página não existe ou foi excluída, volte pra</p>
        <span>home ou nos avise sobre o ocorrido</span>
    </div>
    <div class="btn">
        <a href="<?php echo $home_url; ?>" class="button button--outline">Ir para Home</a>
        <a href="<?php echo $contact_url; ?>" class="button button--outline">Contato</a>
    </div>
</div>

<?php get_footer(); ?>
