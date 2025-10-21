import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import save from './save';
import '../styles/block.scss';

registerBlockType('formularer-for-awork-one/contact-form', {
    apiVersion: 2,
    title:__('Contact Form', 'formularer-for-awork-one'),
    icon: 'email-alt',
    category: 'widgets',
    attributes: {
        headline: {
            type: 'string',
            default: __('Get in Touch With Us', 'formularer-for-awork-one'),
        },
        color: {
            type: 'string',
            default: '#001A56',
        },
        btnColor: {
            "type": "string",
            "default": "#368F8B"
        },
        btnTextColor: {
            "type": "string",
            "default": "#ffffff"
        }
    },
    edit: Edit,
    save
});
