import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Disabled, PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import { QueryPanel } from '../shared/QueryPanel';
import { SelectCardModel } from '../shared/SelectCardModel';

import metadata from './block.json';

function Edit ({ attributes, setAttributes }) {
    const { cardModel, hideAuthor, hideCategories, hideDate, hideExcerpt, postsPerColumn, postsPerRow } = attributes;

    const blockProps = useBlockProps();

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout')}>
                <PanelRow>
                    <SelectCardModel
                        value={cardModel}
                        onChange={(cardModel) => setAttributes({ cardModel })}
                    />
                </PanelRow>

                <PanelRow>
                    <NumberControl
                        label={__('Cards per row', 'hacklabr')}
                        min={1}
                        value={postsPerRow}
                        onChange={(raw) => setAttributes({ postsPerRow: parseInt(raw) })}
                    />
                </PanelRow>

                <PanelRow>
                    <NumberControl
                        label={__('Cards rows', 'hacklabr')}
                        min={1}
                        value={postsPerColumn}
                        onChange={(raw) => setAttributes({ postsPerColumn: parseInt(raw) })}
                    />
                </PanelRow>

                <PanelRow>
                    <ToggleControl
                        label={__('Hide author', 'hacklabr')}
                        checked={hideAuthor}
                        onChange={(hideAuthor) => setAttributes({ hideAuthor })}
                    />
                </PanelRow>

                <PanelRow>
                    <ToggleControl
                        label={__('Hide categories', 'hacklabr')}
                        checked={hideCategories}
                        onChange={(hideCategories) => setAttributes({ hideCategories })}
                    />
                </PanelRow>

                <PanelRow>
                    <ToggleControl
                        label={__('Hide date', 'hacklabr')}
                        checked={hideDate}
                        onChange={(hideDate) => setAttributes({ hideDate })}
                    />
                </PanelRow>

                <PanelRow>
                    <ToggleControl
                        label={__('Hide excerpt', 'hacklabr')}
                        checked={hideExcerpt}
                        onChange={(hideExcerpt) => setAttributes({ hideExcerpt })}
                    />
                </PanelRow>
            </PanelBody>

            <QueryPanel
                attributes={attributes}
                setAttributes={setAttributes}
            />
        </InspectorControls>

        <div {...blockProps}>
            <Disabled>
                <ServerSideRender block="hacklabr/posts-grid" attributes={attributes}/>
            </Disabled>
        </div>
    </>;
}

registerBlockType(metadata.name, {
    edit: Edit,
});
