import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Disabled, Path, Placeholder, SVG } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

function Icon ({ size }) {
    // https://icon-sets.iconify.design/entypo/modern-mic/
    return (
        <SVG height={size} width={size} viewBox="0 0 20 20">
            <Path fill="currentColor" d="M1.228 10.891a.528.528 0 0 0-.159.69l1.296 2.244c.133.23.438.325.677.208L7 12.116V19h2v-7.854l4.071-1.973l-2.62-4.54zm17.229-7.854a4.061 4.061 0 0 0-5.546-1.484c-.91.525-1.508 1.359-1.801 2.289l2.976 5.156c.951.212 1.973.11 2.885-.415a4.06 4.06 0 0 0 1.486-5.546"/>
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
