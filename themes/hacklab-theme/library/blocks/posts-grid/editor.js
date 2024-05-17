import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

export default function Edit ({ attributes }) {
    return (
        <ServerSideRender
            block="hacklabr/posts-grid"
            attributes={attributes}
        />
    );
}

registerBlockType(metadata.name, {
    edit: Edit,
});
