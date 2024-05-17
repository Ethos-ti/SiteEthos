import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

export default function Edit ({ attributes }) {
    return JSON.stringify(attributes);
}

registerBlockType(metadata.name, {
    edit: Edit,
});
