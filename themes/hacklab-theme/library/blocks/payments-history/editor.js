import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Placeholder } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit ({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <Placeholder label={__('Payments history', 'hacklabr')} icon="money-alt"/>
        </div>
    );
}

registerBlockType(metadata.name, {
    edit: Edit,
});
