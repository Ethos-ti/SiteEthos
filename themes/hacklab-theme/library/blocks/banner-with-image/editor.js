import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { mediaAndText as Icon } from '@wordpress/icons';

import { SelectImage } from '../shared/SelectImage';

import metadata from './block.json';

const DEFAULT_BLOCK = ['core/paragraph', { placeholder: __('Header content', 'hacklabr') }];

function Edit ({ attributes, setAttributes }) {
    const { image } = attributes;

    const blockProps = useBlockProps({ className: 'hacklabr-banner-with-image-block' });

    const onImageChange = (image) => {
        const { alt, url } = image;
        setAttributes({ image: { alt, url } });
    };

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout', 'hacklabr')}>
                <PanelRow>
                    <SelectImage
                        label={__('Image', 'hacklabr')}
                        value={image}
                        onChange={onImageChange}
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
            <div className="hacklabr-banner-with-image-block__grid">
                <div className="hacklabr-banner-with-image-block__image">
                    {(image?.url) ? (
                        <img alt={image.alt} src={image.url}/>
                    ) : null}
                </div>
                <div className="hacklabr-banner-with-image-block__text">
                    <InnerBlocks
                        allowedBlocks={true}
                        defaultBlock={DEFAULT_BLOCK}
                        orientation="vertical"
                        renderAppender={InnerBlocks.DefaultBlockAppender}
                        templateLock={false}
                    />
                </div>
            </div>
        </div>
    </>;
}

function Save ({ attributes }) {
    const { image } = attributes;

    const blockProps = useBlockProps.save({ className: 'hacklabr-banner-with-image-block' });

    return (
        <div {...blockProps}>
            <div className="hacklabr-banner-with-image-block__grid">
                <div className="hacklabr-banner-with-image-block__image">
                    {(image?.url) ? (
                        <img alt={image.alt} src={image.url}/>
                    ) : null}
                </div>
                <div className="hacklabr-banner-with-image-block__text">
                    <InnerBlocks.Content/>
                </div>
            </div>
        </div>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save,
});
