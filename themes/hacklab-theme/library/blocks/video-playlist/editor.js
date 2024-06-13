
import { registerBlockType } from '@wordpress/blocks';
import { SelectControl, TextControl } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { useRestApi } from '../shared/hooks';
import metadata from './block.json';


function Edit ({ attributes, setAttributes }) {
    const { numItems, style, title, youtubeFormat, youtubeId } = attributes;

    const { data: options } = useRestApi('hacklabr/v2/options');

   return (
       <>
       {  ! options?.youtubeKey  ?
           <div>Preencha a chave do youtube nas configurações para utilizar o bloco video-playlist</div>
        :
           <div className="video-gallery-wrapper" key="container">
               <div>
                   <TextControl
                       label="Título"
                       value={ title }
                       onChange={ ( title ) => {
                           setAttributes( { title } )
                       } }
                   />

                   <NumberControl
                               label="Quantidade de videos"
                               isShiftStepEnabled={ true }
                               onChange={ ( numItems ) => {
                                   setAttributes( { numItems } )
                               } }
                               min={3}
                               shiftStep={ 1 }
                               value={ numItems }
                   />

                   <SelectControl
                       label="Formato do Youtube"
                       value={ youtubeFormat }
                       options={ [
                           { label: 'Canal', value: 'channel' },
                           { label: 'Playlist', value: 'playlist' },
                       ] }
                       onChange={ ( youtubeFormat ) => {
                           setAttributes( { youtubeFormat } )
                       } }
                   />

                   <TextControl
                       label="ID do Canal/Playlist"
                       value={ youtubeId }
                       onChange={ ( youtubeId ) => {
                           setAttributes( { youtubeId } )
                       } }
                   />

                   <SelectControl
                               label="Estilo"
                               value={ style }
                               options={ [
                                   { label: 'Sidebar', value: 'sidebar' },
                                   { label: 'Bloco', value: 'block' },
                               ] }
                               onChange={ ( style ) => {
                                   setAttributes( { style } )
                               } }
                           />

               </div>
           </div>
           }

       </>
   );
}

registerBlockType(metadata.name, {
    edit: Edit,
});
