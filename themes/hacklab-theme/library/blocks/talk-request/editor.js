import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Disabled, Path, Placeholder, SVG } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

function Icon ({ size }) {
    return (
        <SVG height={size} width={size} viewBox="0 0 24 24">
            <Path fill="currentColor" d="M8 4a2 2 0 1 1-4 0a2 2 0 0 1 4 0M5 16v6H3V10a3 3 0 0 1 5.106-2.137l2.374 2.243l2.313-2.313l1.414 1.414l-3.687 3.687L9 11.46V22H7v-6zm5-11h9v9h-9v2h4.365l2.824 6h2.21l-2.823-6H20a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H10z"/>
        </SVG>
    )
}

function Edit ({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <Disabled>
                <ServerSideRender block={metadata.name} attributes={attributes}/>
            </Disabled>
        </div>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
});
