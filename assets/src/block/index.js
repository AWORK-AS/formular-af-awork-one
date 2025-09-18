import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import save from './save';
import '../styles/block.scss';

registerBlockType('formular-af-awork-one/contact-form', {
    apiVersion: 2,
    title:__('Contact Form', 'formular-af-awork-one'),
    icon: 'email-alt',
    category: 'widgets',
    attributes: {
        headline: {
            type: 'string',
            default: __('Get in Touch With Us', 'formular-af-awork-one'),
        },
        color: {
            type: 'string',
            default: '#205E77',
        },
        btnColor: {
            "type": "string",
            "default": "#42aed9"
        },
        btnTextColor: {
            "type": "string",
            "default": "#ffffff"
        }
    },
    edit: Edit,
    save
});
