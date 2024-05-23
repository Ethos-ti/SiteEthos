import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Path, SVG } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const DEFAULT_BLOCK = ['core/paragraph', { placeholder: __('Body content', 'hacklabr') }]

function Icon ({ size }) {
    return (
        // adapted from https://icon-sets.iconify.design/ion/shirt-outline/
        <SVG height={size} width={size} viewBox="0 0 512 512">
            <Path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth={38} d="M314.56 48s-22.78 8-58.56 8s-58.56-8-58.56-8a32 32 0 0 0-10.57 1.8L32 104l16.63 88l48.88 5.52a24 24 0 0 1 21.29 24.58L112 464h288l-6.8-241.9a24 24 0 0 1 21.29-24.58l48.88-5.52L480 104L325.13 49.8a32 32 0 0 0-10.57-1.8"/>
            <Path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth={38} d="M333.31 52.66a80 80 0 0 1-154.62 0"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const blockProps = useBlockProps({ className: 'card__body' });

    return (
        <main {...blockProps}>
            <InnerBlocks
                allowedBlocks={true}
                defaultBlock={DEFAULT_BLOCK}
                orientation="vertical"
                renderAppender={InnerBlocks.DefaultBlockAppender}
                templateLock={false}
            />
        </main>
    );
}

function Save ({ attributes }) {
    const blockProps = useBlockProps.save({ className: 'card__body' });

    return (
        <main {...blockProps}>
            <InnerBlocks.Content/>
        </main>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save,
});
