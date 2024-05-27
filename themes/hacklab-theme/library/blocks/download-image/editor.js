import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor'
import { registerBlockType } from '@wordpress/blocks'
import { PanelBody, PanelRow, SelectControl } from '@wordpress/components'
import { __ } from '@wordpress/i18n'
import { mediaAndText as Icon } from '@wordpress/icons'

import { SelectImage } from '../shared/SelectImage'

import metadata from './block.json'

const DEFAULT_BLOCK = ['core/paragraph', { placeholder: __('Header content', 'hacklabr') }]

function Edit ({ attributes, setAttributes }) {
    const { format, image } = attributes

    const blockProps = useBlockProps({ className: 'hacklabr-download-image-block' })

    const onImageChange = (image) => {
        const { alt, url } = image
        setAttributes({ image: { alt, url } })
    };

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout')}>
                <PanelRow>
                    <SelectImage
                        label={__('Image')}
                        value={image}
                        onChange={onImageChange}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label={__('Format')}
                        options={ [
                            { label: 'Square', value: 'square' },
                            { label: 'Horizontal', value: 'horizontal' }
                        ] }
                        value={format}
                        onChange={(value) => setAttributes({ format: value })}
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
            <div className="hacklabr-download-image-block__grid">
                <div className="hacklabr-download-image-block__image">
                    {(image?.url) ? (
                        <>
                            <img alt={image.alt} src={image.url}/>
                            <div className={`hacklabr-download-image-block__text hacklabr-download-image-block__text--${format}`}>
                                <InnerBlocks
                                    allowedBlocks={true}
                                    defaultBlock={DEFAULT_BLOCK}
                                    orientation="vertical"
                                    renderAppender={InnerBlocks.DefaultBlockAppender}
                                    templateLock={false}
                                />
                                <a href={image.url} className="hacklabr-download-image-block__icon" download>
                                    <iconify-icon icon="material-symbols:download" style={{ fontSize: '32px' }}></iconify-icon>
                                </a>
                            </div>
                        </>
                    ) : null}
                </div>
            </div>
        </div>
    </>
}

function Save ({ attributes }) {
    const { format, image } = attributes
    const blockProps = useBlockProps.save({ className: 'hacklabr-download-image-block' })

    return (
        <div {...blockProps}>
            <div className="hacklabr-download-image-block__grid">
                <div className="hacklabr-download-image-block__image">
                    {(image?.url) ? (
                        <>
                            <img alt={image.alt} src={image.url}/>
                            <div className={`hacklabr-download-image-block__text hacklabr-download-image-block__text--${format}`}>
                                <InnerBlocks.Content/>
                                <a href={image.url} className="hacklabr-download-image-block__icon" download>
                                    <iconify-icon icon="material-symbols:download" style={{ fontSize: '32px' }}></iconify-icon>
                                </a>
                            </div>
                        </>
                    ) : null}
                </div>
            </div>
        </div>
    )
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save
})
