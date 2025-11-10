import './bootstrap';
import '../css/app.css';
import './echo'; // Импортируем echo после bootstrap

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
