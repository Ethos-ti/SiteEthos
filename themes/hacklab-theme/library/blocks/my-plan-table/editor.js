import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Path, Placeholder, SVG } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const ALLOWED_BLOCKS = ['hacklabr/my-plan-table-row']

const TEMPLATE = [
    ['hacklabr/my-plan-table-row', {}],
]

function Icon ({ size }) {
    // https://icon-sets.iconify.design/grommet-icons/plan/
    return (
        <SVG height={size} width={size} viewBox="0 0 24 24">
            <Path fill="none" stroke="currentColor" stroke-width="2" d="M18 4V0zM7 18H5zm12 0H9zM7 14H5zm12 0H9zM6 4V0zM1 9h22zm0 14h22V4H1z"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const blockProps = useBlockProps({ className: 'my-plan-table' });

    return (
        <div {...blockProps}>
            <Placeholder isColumnLayout={true} label={__('My Plan - Table', 'hacklabr')} icon={Icon}>
                <InnerBlocks
                    allowedBlocks={ALLOWED_BLOCKS}
                    orientation="vertical"
                    renderAppender={InnerBlocks.DefaultBlockAppender}
                    template={TEMPLATE}
                    templateLock={false}
                />
            </Placeholder>
        </div>
    );
}

function Save ({ attributes }) {
    return (
        <InnerBlocks.Content/>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
    save: Save,
});
