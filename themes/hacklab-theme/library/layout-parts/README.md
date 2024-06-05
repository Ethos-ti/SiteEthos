# Partes do layout (`layout parts`)

Essa funcionalidade permite adicionar cabeçalhos, rodapés e sidebars em qualquer página do WordPress usando blocos Gutenberg.

## Instalação

Certifique que o arquivo `/library/layout-parts/layout-parts.php` está sendo incluído no `functions.php` do tema.
Importe o arquivo `/library/layout-parts/Pods/layout-parts.json` utilizando o plugin [Pods](https://br.wordpress.org/plugins/pods/).

## Como usar

### Criando cabeçalhos, rodapés e sidebars

No painel, acesse o menu Aparência/Partes do layout (disponível apenas para usuários administradores) e adicione clique em *Adicionar Novo*. Use blocos Gutenberg para montar sua parte do layout.

Na parte inferior da edição, marque a posição em que deseja usar o layout, sendo cabeçalho, rodapé ou sidebar.

#### Algumas regras importantes para o funcionamento das partes do layout

Sempre inicie o título da parte do layout com a posição como prefixo, por exemplo: *Header Page*.

Após o prefixo, adicione o nome da página em que essa parte do layout deve ser exibida, continuando o exemplo acima: *Page*.

Seguindo o método de hierarquia de templates do WordPress, temos outras regras que permitem a criação de cabeçalhos específicos, por exemplo:

- Header Page 14

- Header Page Contato

- Header Page Template

- Header Page Template Pagina com Âncoras

- Header Page Template Pagina com Âncoras 14

- Header Page Template Pagina com Âncoras Glossário

### Como exibir a parte do layout nos templates PHP do tema

No arquivo PHP, adicione `<?php echo get_layout_part( 'header' ); ?>`, essa função recebe apenas o parâmetro da posição da parte do layout, podendo ser `header`, `footer` ou `sidebar`.

Outras três funções estão disponíveis para exibição das partes do layout e são específicas para cada posição (cabeçalho, rodapé ou sidebar) e essas não recebem parâmetro:

`<?php echo get_layout_part_header(); ?>`, `<?php echo get_layout_part_footer(); ?>` e `<?php echo get_layout_part_sidebar(); ?>`
