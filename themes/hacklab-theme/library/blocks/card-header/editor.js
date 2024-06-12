import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, PanelRow, Path, SVG } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { SelectImage } from '../shared/SelectImage';

import metadata from './block.json';

const DEFAULT_BLOCK = ['core/paragraph', { placeholder: __('Header content', 'hacklabr') }]

function Icon ({ size }) {
    return (
        // https://icon-sets.iconify.design/mdi/head-outline/
        <SVG height={size} width={size} viewBox="0 0 24 24">
            <Path fill="currentColor" d="M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11c-.5.8-.6 1.8-.2 2.6c.4.7 1 1.2 1.7 1.3V16c0 1.8 1.3 3.4 3 3.9V23h11v-5.5c2.5-1.7 4-4.4 4-7.5c0-5-4-9-9-9m3 15.3V21H9v-3H8c-1.1 0-2-.9-2-2v-3H4.5c-.4 0-.7-.5-.4-.8L6 9.7C6.2 6 9.2 3 13 3c3.9 0 7 3.1 7 7c0 2.8-1.6 5.2-4 6.3"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const { backgroundImage } = attributes;

    const style = useMemo(() => {
        return (backgroundImage?.url) ? { backgroundImage: `url(${backgroundImage?.url})` } : undefined;
    }, [backgroundImage]);

    const blockProps = useBlockProps({ className: 'card__header', style });

    const onBackgroundImageChange = (backgroundImage) => {
        const { alt, height, url, width } = backgroundImage;
        setAttributes({ backgroundImage: { alt, height, url, width } });
    };

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout', 'hacklabr')}>
                <PanelRow>
                    <SelectImage
                        label={__('Background image', 'hacklabr')}
                        value={backgroundImage}
                        onChange={onBackgroundImageChange}
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>

        <header {...blockProps}>
            <InnerBlocks
                allowedBlocks={true}
                defaultBlock={DEFAULT_BLOCK}
                orientation="vertical"
                renderAppender={InnerBlocks.DefaultBlockAppender}
                templateLock={false}
            />
        </header>
    </>;
}

function Save ({ attributes }) {
    const { backgroundImage } = attributes;

    const style = (backgroundImage?.url) ? { backgroundImage: `url(${backgroundImage?.url})` } : undefined;

    const blockProps = useBlockProps.save({ className: 'card__header', style });

    return (
        <header {...blockProps}>
            <InnerBlocks.Content/>
        </header>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save,
});
