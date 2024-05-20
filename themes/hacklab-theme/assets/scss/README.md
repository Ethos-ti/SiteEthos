# Padrões de CSS: ITCSS e BEM + overrides

Este documento descreve os padrões de organização e nomenclatura CSS adotados neste projeto, seguindo os princípios do ITCSS (Inverted Triangle CSS) e do [BEM](https://getbem.com/) (Block Element Modifier), garantindo consistência e facilidade de manutenção.

## Orientações básicas

- **SEMPRE** usar variáveis Sass para definir cores, tamanhos, espaçamentos, fontes, etc.;
- **EVITE** estilizar elementos html diretamente, sempre que possível utilizar classes. Caso não seja possível, seja bem específico no seletor, por exemplo: `.myblock>.content>p` e não `.myblock p`;
- Na implementação de um novo componente, verifique se os elementos deste já foram estilizados como objetos na pasta `5.objects` ou como componentes na pasta `6.components`;
- Na implementação de um novo componente, avalie se os elementos que ainda não foram implementados são utilizados em outros componentes do site e, neste caso, implemente-os na pasta `5.objects` ou `6.components`, caso este seja respectivamente um objeto ou um componente, para em seguida utilizá-lo no componente que está sendo criado;
- Se estiver com dúvidas em como seguir o padrão, consulte alguém com mais experiência.

## BEM (Block Element Modifier)

O BEM é uma convenção de nomenclatura para classes CSS que visa tornar o código mais legível e fácil de entender, dividindo-o em blocos, elementos e modificadores.

### Block

O bloco é uma entidade independente e significativa que é responsável por sua aparência e comportamento. Ele é a parte principal e de nível superior de um componente.

Exemplo:

```html
<div class="card"></div>
```

### Element

O elemento é uma parte de um bloco que tem significado semântico apenas em relação a esse bloco. Ele não deve ser usado sozinho.

Exemplo:

```html
<div class="card">
  <div class="card__header"></div>
  <div class="card__content"></div>
</div>
```

### Modifier

O modificador é uma entidade que representa o estado ou a variação de um bloco ou elemento.

Exemplo:

```html
<div class="card card--cover"></div>
```

## ITCSS (Inverted Triangle CSS)

O ITCSS é uma metodologia de organização de arquivos CSS em camadas, distribuídas em um triângulo invertido. Cada camada tem uma responsabilidade específica na estilização de um projeto. As camadas são organizadas da seguinte forma, da mais genérica para a mais específica:

```text
______________
\____________/ -------> 1.SETTINGS
 \__________/ --------> 2.TOOLS
  \________/ ---------> 3.GENERIC
   \______/ ----------> 4.ELEMENTS
    \____/ -----------> 5.OBJECTS
     \__/ ------------> 6.COMPONENTS
      \/ -------------> 7.TRUMPS
```

### Settings

Nesta camada, definimos as variáveis globais como cores, tipografia e espaçamentos.

Exemplos:

```scss
// arquivo 1.constants.scss -- não deve ser modificado
$color--primary-pure:       var(--wp--preset--color--primary-pure);
$color--primary-light:      var(--wp--preset--color--primary-light);
$color--primary-dark:       var(--wp--preset--color--primary-dark);

// arquivo 2.variables.scss -- pode ser modificado
$break--small: 36rem; // 576px
$break--tablet: 48rem; // 768px
$break--desktop: 62rem; // 992px

$grid--wide: 75rem;
$grid--normal: 48rem;
$grid--narrow: 37.5rem;
```

### Tools

Camada responsável por definir funções e utilitários que serão utilizados ao longo do projeto, como mixins de media queries e funções de cálculo.

Exemplo:

```scss
@mixin small {
  @media (max-width: $break--small) {
    @content;
  }
}
```

### Generic

Nesta camada, aplicamos estilos muito genéricos que afetam todo o projeto, como resets e estilos para tags HTML.

Exemplo:

```scss
*, *::before, *::after {
    box-sizing: border-box;
}

* {
    margin: 0;
}

html {
    scroll-behavior: smooth;
}

```

### Elements

Aqui definimos estilos para elementos HTML básicos, como headings, listas e links.

Exemplo:

```scss
h1, h2, h3, h4 {
    font-family: $font-family--heading;
    line-height: $line-height--tight;
}

h1 {
    font-size: $font-size--hero;

    @include mobile {
        font-size: $font-size-mobile--hero;
    }
}
```

### Objects

Camada destinada à estilização de objetos, como containers e grids, botões, inputs etc.

Exemplo:

```scss
.container {
    margin-inline: auto;
    max-width: $grid--normal;
    padding-inline: $padding--medium;
    width: 100%;

    &--wide {
        max-width: $grid--wide;
    }

    &--narrow {
        max-width: $grid--narrow;
    }
}
```

Os objetos **NÃO** devem implementar qualquer estilização externa, como margens, position, width ou max-width; quem define é componente que utiliza o objeto, como no exemplo abaixo onde é colocado uma _margem medium_ no primeiro botão e um _gap large_ entre os botões

```html
<div class="container -gap-large">
    <button class="button -margin-medium">Botão 1</button>
    <button class="button button--large">Botão 2</button>

```

### Components

Nesta camada, definimos estilos para componentes reutilizáveis do projeto, como botões, cards e formulários.

Exemplo:

```scss
.social-menu {
    align-items: center;
    display: flex;
    gap: $gap--small;

    &__icon {

        svg {
            height: 1em;
            width: 1em;
        }
    }
}
```

Os componentes, assim como os objetos, **NÃO** devem implementar qualquer estilização externa, como margens, position, width ou max-width;

### Trumps

Camada destinada a estilos de alto nível que substituem ou anulam estilos definidos em camadas anteriores.

Exemplo:

```scss
.-text-center {
    text-align: center !important;
}
```

## Overrides

Como trabalharemos com vários componentes (blocos) de terceiros, sempre que precisemos estilizar estes componentes, devemos criar um arquivo separado para estilizar este elemento na pasta `9.overrides`.

Apesar de que os estilos desta pasta não necessariamente seguem o padrão BEM para nomenclatura, devemos **SEMPRE** utilizar as variáveis definidas em `1.constants.scss` ou `2.variables.scss` para fazer a estilização.
