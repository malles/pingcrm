import Vue from 'vue';
import { library, } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon, } from '@fortawesome/vue-fontawesome';
import {
    faTrashAlt,
    faChevronDown,
    faChevronRight,
    faChevronUp,
    faTrash,
} from '@fortawesome/pro-regular-svg-icons';
import {
    faTachometerAlt,
    faBoxesAlt,
    faTruckLoading,
    faHouseDay,
    faFileSignature,
} from '@fortawesome/pro-duotone-svg-icons';

library.add(
    faTrashAlt,
    faChevronDown,
    faChevronRight,
    faChevronUp,
    faTrash,
    faTachometerAlt,
    faBoxesAlt,
    faTruckLoading,
    faHouseDay,
    faFileSignature,
);

Vue.component('Icon', FontAwesomeIcon);
