import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Disabled, PanelBody, PanelRow } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import { QueryPanel } from '../shared/QueryPanel';
import { SelectCardModel } from '../shared/SelectCardModel';

import metadata from './block.json';

export default function Edit ({ attributes, setAttributes }) {
    const { cardModel, postsPerColumn, postsPerRow } = attributes;

    const blockProps = useBlockProps();

    const onCardModelChange = (cardModel) => setAttributes({ cardModel });
    const onPostsPerColumnChange = (raw) => setAttributes({ postsPerColumn: parseInt(raw) });
    const onPostsPerRowChange = (raw) => setAttributes({ postsPerRow: parseInt(raw) });

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout')}>
                <PanelRow>
                    <NumberControl
                        label={__('Cards per row', 'hacklabr')}
                        min={1}
                        value={postsPerRow}
                        onChange={onPostsPerRowChange}
                    />
                </PanelRow>

                <PanelRow>
                    <NumberControl
                        label={__('Cards rows', 'hacklabr')}
                        min={1}
                        value={postsPerColumn}
                        onChange={onPostsPerColumnChange}
                    />
                </PanelRow>

                <PanelRow>
                    <SelectCardModel value={cardModel} onChange={onCardModelChange}/>
                </PanelRow>
            </PanelBody>

            <QueryPanel attributes={attributes} setAttributes={setAttributes}/>
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
