import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, PanelRow } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const ALLOWED_BLOCKS = ['core/paragraph'];

const TEMPLATE = [
    ['core/paragraph', { placeholder: __('Full text', 'hacklabr') }]
]

function Edit ({ attributes, setAttributes }) {
    const { lines } = attributes;

    const style = useMemo(() => ({ '--lines-shown': String(lines) }), [lines]);

    const blockProps = useBlockProps({ className: 'hacklabr-read-more-block', style });

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout')}>
                <PanelRow>
                    <NumberControl
                        label={__('Lines shown', 'hacklabr')}
                        min={1}
                        value={lines}
                        onChange={(value) => setAttributes({ lines: parseInt(value) })}
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
            <div className="hacklabr-read-more-block__content">
                <InnerBlocks
                    allowedBlocks={ALLOWED_BLOCKS}
                    orientation="vertical"
                    template={TEMPLATE}
                    templateLock="all"
                />
            </div>
            <button className="hacklabr-read-more-block__toggle">{__('Read more', 'hacklabr')}</button>
        </div>
    </>;
}

function Save ({ attributes }) {
    const { lines } = attributes;

    const style = { '--lines-shown': String(lines) };

    const blockProps = useBlockProps.save({ className: 'hacklabr-read-more-block', style });

    return (
        <div {...blockProps}>
            <div className="hacklabr-read-more-block__content">
                <InnerBlocks.Content/>
            </div>
            <button className="hacklabr-read-more-block__toggle">{__('Read more', 'hacklabr')}</button>
        </div>
    );
}

registerBlockType(metadata.name, {
    edit: Edit,
    save: Save,
});
