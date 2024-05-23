import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Path, SVG } from '@wordpress/components';

import metadata from './block.json';

const ALLOWED_BLOCKS = ['hacklabr/card-header', 'hacklabr/card-body'];

const TEMPLATE = [
    ['hacklabr/card-header', {}],
    ['hacklabr/card-body', {}],
]

function Icon ({ size }) {
    // https://icon-sets.iconify.design/fluent/window-24-filled/
    return (
        <SVG height={size} width={size} viewBox="0 0 24 24">
            <Path fill="currentColor" d="M3 6.25A3.25 3.25 0 0 1 6.25 3h11.5A3.25 3.25 0 0 1 21 6.25v11.5A3.25 3.25 0 0 1 17.75 21H6.25A3.25 3.25 0 0 1 3 17.75zm1.5 11.5c0 .966.784 1.75 1.75 1.75h11.5a1.75 1.75 0 0 0 1.75-1.75V8.5h-15z"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const blockProps = useBlockProps({ className: 'card' });

    return (
        <div {...blockProps}>
            <InnerBlocks
                allowedBlocks={ALLOWED_BLOCKS}
                orientation="vertical"
                template={TEMPLATE}
                templateLock="all"
            />
        </div>
    );
}

function Save ({ attributes }) {
    const blockProps = useBlockProps.save({ className: 'card' });

    return (
        <div {...blockProps}>
            <InnerBlocks.Content/>
        </div>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save,
});
