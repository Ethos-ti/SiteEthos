import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Disabled, PanelBody, PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import { QueryPanel } from '../shared/QueryPanel';

import metadata from './block.json';

export default function Edit ({ attributes, setAttributes }) {
    const { cardModel, postsPerColumn, postsPerRow } = attributes;

    const blockProps = useBlockProps();

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Layout')}>
                <PanelRow>

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
