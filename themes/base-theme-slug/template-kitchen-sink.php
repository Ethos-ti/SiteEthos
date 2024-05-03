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

    <div class="form-field">
        <label for="input-1" class="form-field__label">Texto</label>
        <input id="input-1" class="text-input" type="text">
    </div>

    <div class="form-field">
        <label for="select-1" class="form-field__label">Select</label>
        <select id="select-1" class="select">
            <option>Opção 1</option>
            <option>Opção 2</option>
        </select>
    </div>

    <div class="form-field">
        <label for="checkbox-1" class="form-field__label">Checkbox 1</label>
        <input id="checkbox-1" class="checkbox" type="checkbox">
    </div>

    <div class="form-field">
        <input id="checkbox-2" class="checkbox" type="checkbox">
        <label for="checkbox-2" class="form-field__label">Checkbox 2</label>
    </div>

    <div class="form-field">
        <label for="radio-1" class="form-field__label">Radio 1</label>
        <input id="radio-1" class="radio" type="radio">
    </div>

    <div class="form-field">
        <input id="radio-2" class="radio" type="radio">
        <label for="radio-2" class="form-field__label">Radio 2</label>
    </div>

    <hr/>

    <div class="form-field form-field--disabled">
        <label for="input-2" class="form-field__label">Texto</label>
        <input id="input-2" class="text-input text-input--disabled" type="text" disabled>
    </div>

    <div class="form-field form-field--disabled">
        <label for="select-2" class="form-field__label">Select</label>
        <select id="select-2" class="select select--disabled" disabled>
            <option>Opção 1</option>
            <option>Opção 2</option>
        </select>
    </div>

    <div class="form-field form-field--disabled">
        <label for="checkbox-3" class="form-field__label">Checkbox</label>
        <input id="checkbox-3" class="checkbox checkbox--disabled" type="checkbox" disabled>
    </div>

    <div class="form-field form-field--disabled">
        <label for="radio-3" class="form-field__label">Radio</label>
        <input id="radio-3" class="radio radio--disabled" type="radio" disabled>
    </div>

    <hr/>

    <div class="form-field form-field--error">
        <label for="input-3" class="form-field__label">Texto</label>
        <input id="input-3" class="text-input text-input--error" type="text">
    </div>

    <div class="form-field form-field--error">
        <label for="select-3" class="form-field__label">Select</label>
        <select id="select-3" class="select select--error">
            <option>Opção 1</option>
            <option>Opção 2</option>
        </select>
    </div>

    <div class="form-field form-field--error">
        <label for="checkbox-4" class="form-field__label">Checkbox</label>
        <input id="checkbox-4" class="checkbox checkbox--error" type="checkbox">
    </div>

    <div class="form-field form-field--error">
        <label for="radio-4" class="form-field__label">Radio</label>
        <input id="radio-4" class="radio radio--error" type="radio">
    </div>

    <hr/>

    <svg class="hamburger" role="image" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <title>Exibir menu</title>
        <rect width="16" height="2" x="0" y="2"/>
        <rect width="16" height="2" x="0" y="7"/>
        <rect width="16" height="2" x="0" y="12"/>
    </svg>

    <svg class="hamburger hamburger--open" role="image" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <title>Ocultar menu</title>
        <rect width="16" height="2" x="0" y="2"/>
        <rect width="16" height="2" x="0" y="7"/>
        <rect width="16" height="2" x="0" y="12"/>
    </svg>

    <svg id="hamburger-animation" class="hamburger" role="image" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <rect width="16" height="2" x="0" y="2"/>
        <rect width="16" height="2" x="0" y="7"/>
        <rect width="16" height="2" x="0" y="12"/>
    </svg>

    <script>
        window.setInterval(() => {
            document.querySelector('#hamburger-animation')?.classList.toggle('hamburger--open')
        }, 3000)
    </script>
</div>

<?php get_footer(); ?>
