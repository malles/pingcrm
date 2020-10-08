import Vue from 'vue';
import { library, } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon, } from '@fortawesome/vue-fontawesome';
import {
    faTrashAlt,
    faChevronDown,
    faChevronRight,
} from '@fortawesome/pro-regular-svg-icons';
import {
    faTachometerAlt,
    faBoxesAlt,
    faTruckLoading,
    faHouseDay,
} from '@fortawesome/pro-duotone-svg-icons';

library.add(
    faTrashAlt,
    faChevronDown,
    faChevronRight,
    faTachometerAlt,
    faBoxesAlt,
    faTruckLoading,
    faHouseDay,
);

Vue.component('Icon', FontAwesomeIcon);
