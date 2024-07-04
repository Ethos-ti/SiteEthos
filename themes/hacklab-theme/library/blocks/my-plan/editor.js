import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Path, Placeholder, SVG } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Icon ({ size }) {
    // https://icon-sets.iconify.design/grommet-icons/plan/
    return (
        <SVG height={size} width={size} viewBox="0 0 24 24">
            <Path fill="none" stroke="currentColor" stroke-width="2" d="M18 4V0zM7 18H5zm12 0H9zM7 14H5zm12 0H9zM6 4V0zM1 9h22zm0 14h22V4H1z"/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <Placeholder label={__('My Plan', 'hacklabr')} icon={Icon}/>
        </div>
    );
}

registerBlockType(metadata.name, {
    icon: Icon,
    edit: Edit,
});
