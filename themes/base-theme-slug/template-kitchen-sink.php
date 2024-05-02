<?php
/**
 * Template Name: Inventário de componentes
 */
get_header();
?>

<div class="container kitchen-sink">
    <h1>&lt;h1&gt; Título 1</h1>
    <h2>&lt;h2&gt; Título 2</h2>
    <h3>&lt;h3&gt; Título 3</h3>
    <h4>&lt;h4&gt; Título 4</h4>
    <h5>&lt;h5&gt; Título 5</h5>
    <h6>&lt;h6&gt; Título 6</h6>
    <p>&lt;p&gt; Parágrafo</p>

    <hr/>

    <button type="button" class="button">Default</button>
    <button type="button" class="button button--solid">Solid</button>
    <button type="button" class="button button--outline">Outline</button>
    <button type="button" class="button button--solid button--large">Large</button>
    <button type="button" class="button button--solid button--small">Small</button>
    <button type="button" class="button button--solid button--primary">Primary</button>
    <button type="button" class="button button--solid button--secondary">Secondary</button>
    <button type="button" class="button button--solid button--highlight">Highlight</button>
    <button type="button" class="button button--outline button--warning">Warning</button>
    <button type="button" class="button button--solid button--helper">Helper</button>

    <hr/>

    <div class="site-by-hacklab">
        <div class="container">
            <a href="https://hacklab.com.br">site por <strong>hacklab<span>/</span></strong></a>
        </div>
    </div>

    <hr/>

    <div class="stack stack--large">
        <div class="stack">
            <div class="kitchen-sink__stack-item">Item</div>
            <div class="kitchen-sink__stack-item">Item</div>
            <div class="kitchen-sink__stack-item">Item</div>
        </div>

        <div class="stack stack--small">
            <div class="kitchen-sink__stack-item">Item</div>
            <div class="kitchen-sink__stack-item">Item</div>
            <div class="kitchen-sink__stack-item">Item</div>
        </div>

        <div class="stack stack--large">
            <div class="kitchen-sink__stack-item">Item</div>
            <div class="kitchen-sink__stack-item">Item</div>
            <div class="kitchen-sink__stack-item">Item</div>
        </div>
    </div>

    <hr/>

    <label class="form-field">
        <span class="form-field__label">Texto</span>
        <input class="text-input" type="text">
    </label>

    <label class="form-field">
        <span class="form-field__label">Select</span>
        <select class="select">
            <option>Opção 1</option>
            <option>Opção 2</option>
        </select>
    </label>

    <label class="form-field">
        <span class="form-field__label">Checkbox 1</span>
        <input class="checkbox" type="checkbox">
    </label>

    <label class="form-field">
        <input class="checkbox" type="checkbox">
        <span class="form-field__label">Checkbox 2</span>
    </label>

    <label class="form-field">
        <span class="form-field__label">Radio 1</span>
        <input class="radio" type="radio">
    </label>

    <label class="form-field">
        <input class="radio" type="radio">
        <span class="form-field__label">Radio 2</span>
    </label>

    <hr/>

    <label class="form-field form-field--disabled">
        <span class="form-field__label">Texto</span>
        <input class="text-input text-input--disabled" type="text" disabled>
    </label>

    <label class="form-field form-field--disabled">
        <span class="form-field__label">Select</span>
        <select class="select select--disabled" disabled>
            <option>Opção 1</option>
            <option>Opção 2</option>
        </select>
    </label>

    <label class="form-field form-field--disabled">
        <span class="form-field__label">Checkbox</span>
        <input class="checkbox checkbox--disabled" type="checkbox" disabled>
    </label>

    <label class="form-field form-field--disabled">
        <span class="form-field__label">Radio</span>
        <input class="radio radio--disabled" type="radio" disabled>
    </label>

    <hr/>

    <label class="form-field form-field--error">
        <span class="form-field__label">Texto</span>
        <input class="text-input text-input--error" type="text">
    </label>

    <label class="form-field form-field--error">
        <span class="form-field__label">Select</span>
        <select class="select select--error">
            <option>Opção 1</option>
            <option>Opção 2</option>
        </select>
    </label>

    <label class="form-field form-field--error">
        <span class="form-field__label">Checkbox</span>
        <input class="checkbox checkbox--error" type="checkbox">
    </label>

    <label class="form-field form-field--error">
        <span class="form-field__label">Radio</span>
        <input class="radio radio--error" type="radio">
    </label>
</div>

<?php get_footer(); ?>
