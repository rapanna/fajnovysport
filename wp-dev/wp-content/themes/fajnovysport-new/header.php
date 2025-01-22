<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
<style>
/* Css from OLD fajnoysport */
.dropdown-item.active {
  background-color: #027e97;
}

@media (min-width: 769px) {
  .navbar-expand-md .navbar-nav .nav-link {
    padding-right: 1rem;
    padding-left: 1rem;
  }
}
@media (min-width: 1300px) {
  .navbar-expand-md .navbar-nav .nav-link {
    padding-right: 3rem;
    padding-left: 3rem;
  }
}
.navbar-toggler {
  color: rgba(255, 255, 255, 0.5);
  margin-left: 2rem;
}

.navbar-toggler-icon {
  color: rgba(255, 255, 255, 0.5);
}

.navbar-toggler-icon {
  background-image: url("../img/svg/burger.svg");
}

@media only screen and (max-width: 768px) {
  .nav {
    display: block;
  }

  .navbar-collapse.collapse, .navbar-collapse.collapsing {
    margin-left: 2rem;
  }
}
.menu-item {
  margin-left: 1px;
  margin-right: 1px;
}

.sec {
  padding-bottom: 2rem;
  margin-top: 8rem;
}
@media only screen and (max-width: 767px) {
  .sec {
    margin-top: 3rem;
  }
}

.sec--news {
  margin-top: 8rem;
}
@media only screen and (max-width: 767px) {
  .sec--news {
    margin-top: 3rem;
  }
}

.sec--category .category-box {
  margin-bottom: 5.7rem;
}

.sec--pagination {
  margin-bottom: 6rem;
}

.sec--selectmapa {
  background-color: #203048;
  margin: 0;
  padding: 1.2rem 0;
}

.sec--mapa {
  margin: 0;
  padding: 0;
}
.sec--mapa .col-sm-7.col-md-8 {
  padding-right: 0;
}

.ico {
  display: block;
}

.ico__facebook {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 0;
  width: 37px;
  height: 37px;
  background-image: url("../img/svg/ico-fcb.svg");
}
@media only screen and (max-width: 460px) {
  .ico__facebook {
    right: 2rem;
  }
}
@media only screen and (max-width: 768px) {
  .ico__facebook {
    right: 2rem;
  }
}
@media only screen and (min-width: 769px) and (max-width: 991px) {
  .ico__facebook {
    top: 73%;
  }
}

.ico__facebook--mapa {
  right: 3rem;
}

.ico__ig {
  right: 5rem;
  background-image: url("../img/svg/ico-ig.svg");
}
@media only screen and (max-width: 768px) {
  .ico__ig {
    right: 7rem;
  }
}

.title {
  font-weight: 700;
  color: #027e97;
}
.title a {
  text-decoration: none;
}

.title--h1 {
  font-size: 3.3rem;
  font-weight: 700;
  line-height: 4.3rem;
  text-transform: uppercase;
  color: #203048;
  margin-top: 0;
}
.title--h1 a {
  color: #203048;
  border-bottom: 2px solid transparent;
}
.title--h1 a:hover {
  border-bottom-color: #203048;
}

.title--h2 {
  font-size: 3.3rem;
  margin-bottom: 3rem;
}

.title__theme {
  color: #203048;
  text-decoration: none;
  border-bottom: 2px solid transparent;
}

.title__link {
  color: #203048;
  text-decoration: none;
  border-bottom: 2px solid transparent;
}
.title__link:hover {
  border-bottom: 2px solid #203048;
}

.title--number {
  text-align: center;
  color: #203048;
  margin-bottom: 2.5rem;
}

.title--top {
  margin-bottom: 6.6rem;
}

.sec--single .title--top {
  margin-bottom: 2.2rem;
}

.title--subtitle {
  font-size: 1.9rem;
  line-height: 2.3rem;
  font-weight: 700;
  margin-bottom: 0.8rem;
  margin-top: 0;
}
.title--subtitle a {
  color: #203048;
  border-bottom: 2px solid transparent;
}
.title--subtitle a:hover {
  border-bottom-color: #203048;
}

.title--mapa {
  font-size: 2rem;
  font-weight: 700;
  color: #203048;
  margin-bottom: 1.5rem;
}

.title--mapboxgl {
  color: #203048;
  font-weight: 700;
  margin-bottom: 1rem;
  line-height: normal;
  font-size: 1.7rem;
}

.title--mapa-detail {
  color: #203048;
  font-size: 2rem;
  margin-top: 0;
  margin-bottom: 0.9rem;
}

.title--subfoto {
  margin-top: 1.5rem;
}

.btn--more {
  color: #02cff7;
  font-size: 1.9rem;
  font-weight: 700;
  text-transform: uppercase;
  padding: 0 2.8rem;
  border: 2px solid #02cff7;
  text-decoration: none;
  line-height: 4rem;
}

.searchform {
  width: 100%;
  max-width: 32rem;
  height: 5.6rem;
  background-color: #eaeaea;
  border-radius: 2.8rem;
  display: inline-block;
}
@media only screen and (max-width: 460px) {
  .searchform {
    max-width: 24rem;
  }
}
@media only screen and (min-width: 769px) {
  .searchform {
    position: absolute;
    top: 39%;
    transform: translateY(-50%);
    max-width: 29.5rem;
  }
}
@media only screen and (min-width: 992px) {
  .searchform {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
  }
}

.searchform__label {
  position: absolute;
  left: -999999999999px;
}

.searchform__input {
  font-size: 1.7rem;
  line-height: 4.1rem;
  margin-top: 0.6rem;
  margin-left: 2rem;
  border: 0;
  background-color: transparent;
  color: #203048;
  width: calc(100% - 73px);
  vertical-align: middle;
}
.searchform__input::-moz-placeholder {
  color: #203048;
  opacity: 1;
}
.searchform__input:-ms-input-placeholder {
  color: #203048;
  opacity: 1;
}
.searchform__input::placeholder {
  color: #203048;
  opacity: 1;
}
.searchform__input:focus {
  outline: 0 !important;
}

.searchform__btn {
  border: 0;
  background-color: transparent;
  width: 41px;
  height: 41px;
  background-image: url("../img/svg/ico-search.svg");
  font-size: 0;
  vertical-align: middle;
  margin-top: 0.6rem;
}
.searchform__btn:hover {
  filter: invert(1);
}

.search__btn2 {
  border: 0;
  background-color: transparent;
  width: 2rem;
  height: 2rem;
  background-image: url("../img/svg/mapa_search.svg");
  font-size: 0;
  vertical-align: middle;
}

.news {
  margin-bottom: 8px;
}

.news-link__title, .shot-link-text {
  background-color: #027e97;
  color: #fff;
  font-size: 1.9rem;
  padding-top: 1.6rem;
  padding-bottom: 1.3rem;
  padding-left: 2rem;
  padding-right: 2rem;
  font-weight: 700;
  position: relative;
  z-index: 999;
}

.news-link, .shot-link {
  display: block;
  text-decoration: none;
  overflow: hidden;
}
.news-link img, .shot-link img {
  width: 100%;
  /* height: auto; */
  transition: transform 0.5s ease;
}
.news-link:hover .news-link__title, .news-link:hover .shot-link-text, .shot-link:hover .news-link__title, .shot-link:hover .shot-link-text {
  background-color: #203048;
}
.news-link:hover img, .shot-link:hover img {
  transform: scale(1.1);
}

.shot-link-text__span {
  position: relative;
  display: block;
  padding-left: 5rem;
}
@media only screen and (min-width: 992px) {
  .shot-link-text__span {
    display: inline-block;
  }
}
.shot-link-text__span::before {
  content: "";
  position: absolute;
  left: -0.5rem;
  top: -4px;
  background-repeat: no-repeat;
}

@media only screen and (min-width: 992px) {
  .shot-link-text__span--date {
    margin-left: 12rem;
    padding-top: auto;
  }
}
.shot-link-text__span--date::before {
  width: 36px;
  height: 32px;
  background-image: url("../img/svg/kalendar.svg");
}

.shot-link-text__span--place {
  margin-bottom: 1rem;
}
@media only screen and (min-width: 992px) {
  .shot-link-text__span--place {
    margin-bottom: auto;
  }
}
.shot-link-text__span--place::before {
  width: 30px;
  height: 32px;
  left: 0;
  background-image: url("../img/svg/bod.svg");
}

.news-link__title {
  min-height: 12rem;
}

.news--big .news-link__title {
  min-height: auto;
}

@media only screen and (min-width: 769px) and (max-width: 999px) {
  .col-md-4 .news .news-link__title {
    height: 17rem;
  }
}
@media only screen and (min-width: 1300px) {
  .col-md-4 .news .news-link__title {
    margin-bottom: -30px;
  }
}
.theme {
  display: block;
  margin-bottom: 8px;
  display: block;
  text-decoration: none;
  overflow: hidden;
}
.theme:hover .theme-link__text {
  background-color: #203048;
}
.theme:hover .theme-link__img {
  transform: scale(1.1);
}

.theme-link__img {
  width: 100%;
  cursor: pointer;
  transition: transform 0.5s ease;
}
@media only screen and (max-width: 768px) {
  .theme-link__img {
    height: auto;
  }
}
@media only screen and (min-width: 769px) {
  .theme-link__img {
    max-width: 40rem;
  }
}

.theme-link__text {
  background-color: #027e97;
  color: #fff;
  font-size: 1.9rem;
  padding-top: 1.6rem;
  padding-bottom: 1.6rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  font-weight: 700;
  position: relative;
  z-index: 999;
}

.number__title {
  text-align: center;
  font-size: 9.9rem;
  line-height: 13.2rem;
  font-weight: 700;
  color: #203048;
  margin-bottom: 1rem;
}

.number__subtitle {
  font-size: 3.1rem;
  color: #027e97;
  font-weight: 700;
  line-height: 4.6rem;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 0.7rem;
}

.number__text {
  text-align: center;
  font-size: 1.6rem;
  font-weight: 400;
  text-transform: uppercase;
  line-height: 2.9rem;
  color: #203048;
}

.panel {
  color: #203048;
  font-size: 4rem;
  line-height: normal;
  margin-bottom: 2rem;
  font-weight: bold;
  font-weight: 700;
  text-transform: uppercase;
}

.panel--dark {
  padding-top: 2rem;
  text-align: center;
  margin-bottom: 0.9rem;
}
@media only screen and (min-width: 768px) {
  .panel--dark {
    padding-top: 16rem;
    text-align: left;
  }
}

.panel--light {
  margin-bottom: 2rem;
  text-align: center;
  color: #027e97;
}
@media only screen and (min-width: 768px) {
  .panel--light {
    text-align: left;
  }
}

.panel__img {
  max-width: 100%;
  height: auto;
  position: relative;
  z-index: 99999;
}

.category__info {
  font-size: 1.4rem;
  font-weight: 400;
  color: #203048;
  margin-bottom: 2.2rem;
}
.category__info > span {
  display: inline-block;
  padding-right: 1.2rem;
  padding-left: 0.8rem;
  font-weight: 100;
  line-height: 1.7rem;
}
.category__info > span:first-child {
  padding-left: 0;
}
.category__info a {
  color: #203048;
  text-decoration: none;
  border-bottom: 1px solid transparent;
  font-weight: 400;
}
.category__info a:hover {
  border-bottom-color: #000;
}
.category__info .category {
  border-right: 2px solid #027e97;
  padding-left: 0;
}

.category__text {
  color: #757575;
  line-height: 2.6rem;
  font-size: 1.4rem;
  margin-bottom: 3rem;
}

.category__link img {
  max-width: 100%;
  height: auto;
  transition: transform 0.5s ease;
}
@media only screen and (max-width: 768px) {
  .category__link img {
    max-width: 100%;
  }
}

.category__link--image {
  display: block;
  text-decoration: none;
  overflow: hidden;
}

.category__link--image:hover img {
  transform: scale(1.1);
}

.category__link--btn {
  font-size: 1.7rem;
  color: #fff;
  display: inline-block;
  padding: 0.5rem 2.3rem;
  background-color: #027e97;
  text-transform: uppercase;
  font-weight: 700;
  text-decoration: none;
  border: 2px solid #027e97;
}
.category__link--btn:hover {
  background-color: #fff;
  border-color: #027e97;
  color: #027e97;
}

.category__separator:last-child {
  display: none;
}

.cathegory_link--more {
  margin: auto;
  margin-top: 1rem;
}

.pagination {
  margin: 0;
  padding: 0;
  list-style: none;
}
.pagination li {
  display: inline-block;
  margin-left: 0.8rem;
  margin-right: 0.8rem;
}
.pagination li:first-child {
  margin-left: 0rem;
}
.pagination a, .pagination span {
  font-weight: 700;
  color: #027e97;
  font-size: 2.3rem;
  display: inline-block;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
  margin-left: 0.7rem;
  margin-right: 0.7rem;
  text-decoration: none;
}
.pagination a:first-child, .pagination span:first-child {
  margin-left: 0rem;
}

.info {
  font-size: 1.6rem;
  font-weight: 400;
  color: #203048;
  margin-bottom: 4.2rem;
}
.info a {
  color: #203048;
  text-decoration: none;
  border-bottom: 1px solid transparent;
  font-weight: 400;
}
.info a:hover {
  border-bottom-color: #000;
}
.info .single__author {
  padding-right: 1.2rem;
  border-right: 2px solid #027e97;
}
.info .single__date {
  font-weight: 100;
  font-style: italic;
  padding-left: 1.2rem;
}

.single__perex {
  font-weight: 700;
  color: #757575;
  margin-bottom: 2.4rem;
}

.entry {
  color: #757575;
  font-size: 1.5rem;
  font-weight: 400;
  padding-bottom: 6rem;
}
.entry .thumbnail {
  float: left;
  margin-top: 0;
  margin-right: 3.1rem;
  margin-bottom: 3.3rem;
  overflow: hidden;
}
@media only screen and (max-width: 768px) {
  .entry .thumbnail {
    float: none;
    margin-left: auto;
    margin-right: auto;
  }
}
.entry .thumbnail a {
  text-decoration: none;
}
.entry .thumbnail img {
  width: 100%;
  max-width: 60rem;
  height: auto;
  margin: 0;
  padding: 0;
}
.entry .thumbnail span {
  width: 100%;
  background-color: #027e97;
  display: block;
  color: #fff;
  font-size: 1.3rem;
  padding-top: 1.3rem;
  padding-bottom: 1.3rem;
  padding-left: 2.2rem;
}
.entry p {
  line-height: 3rem;
  margin-bottom: 2rem;
}
.entry .wp-block-image {
  margin-top: 3rem !important;
  margin-bottom: 3rem !important;
}
.entry .wp-block-image img {
  height: auto;
}

.news_box {
  overflow: hidden;
}

.fbox-article {
  overflow: hidden;
}

.fbox-article {
  margin-top: 3rem;
}

.fbox-title {
  padding-top: 1rem;
}

.fbox-title__date {
  margin-top: 1rem;
}

.fbox__perex {
  margin-top: 1rem;
}

.single__buton {
  margin-top: 5rem;
  margin-bottom: 5rem;
}

.marker--akce {
  background-image: url("../img/marker-akce.png");
  background-size: cover;
  width: 27px;
  height: 45px;
  margin-top: -22px;
  cursor: pointer;
}

.marker--sportoviste {
  background-image: url("../img/marker-sportoviste.png");
  background-size: cover;
  width: 27px;
  height: 45px;
  margin-top: -22px;
  cursor: pointer;
}

.marker--kluby {
  background-image: url("../img/marker-kluby.png");
  background-size: cover;
  width: 27px;
  height: 45px;
  margin-top: -22px;
  cursor: pointer;
}

.mapboxgl-popup {
  margin-top: 0px !important;
  position: relative;
}

.autocomplete-active {
  color: #027e97;
}

.selected {
  color: white;
}

.selected:hover {
  color: white;
}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #027e97;
  width: 120px;
  min-height: 120px;
  /* Safari */
  animation: spin 2s linear infinite;
}

.loader-left {
  margin: 0 auto;
  margin-top: 12rem;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #027e97;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
  display: none;
}

.loader-right {
  margin: 0 auto;
  margin-top: 24vh;
  z-index: 100000;
  position: absolute;
  margin-left: 28vw;
  display: none;
}

/* Safari */
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.sports--more {
  display: none;
}

#more_sports--div {
  display: none;
}

#less_sports {
  display: none;
}

.mapa-more {
  float: right;
  margin-right: 3rem;
  text-align: center;
  position: relative;
  top: 50%;
  transform: translateY(-50%);
  -webkit-transform: translateY(-50%);
}
@media only screen and (max-width: 768px) {
  .mapa-more {
    float: none;
  }
}

.mapa-select {
  width: calc(100% - 24rem);
  display: inline-block;
  margin-left: 3rem;
  padding-bottom: 1rem;
  padding-top: 1rem;
}
@media only screen and (max-width: 768px) {
  .mapa-select {
    display: block;
    width: 100%;
  }
}

.mapa-select__link {
  font-size: 1.6rem;
  font-weight: 100;
  color: #203048;
  line-height: 4rem;
  border-radius: 2rem;
  background-color: #fff;
  display: inline-block;
  padding: 0 3.5rem 0 2rem;
  text-decoration: none;
  margin-top: 0;
  margin-bottom: 0;
  margin-right: 1.4rem;
  position: relative;
}
@media only screen and (max-width: 1200px) {
  .mapa-select__link {
    margin-bottom: 0.5rem;
  }
}

.mapa-search {
  width: 20rem;
  display: inline-block;
  padding-bottom: 1rem;
  padding-top: 1rem;
}
@media only screen and (max-width: 768px) {
  .mapa-search {
    display: block;
  }
}

.mapa-search-form {
  background-color: #fff;
  height: 4rem;
  border-radius: 2rem;
  margin-bottom: 1.4rem;
}

.mapa-search-form__label {
  position: absolute;
  left: -111111rem;
}

.mapa-search-form__input {
  width: calc(100% - 5rem);
  display: inline-block;
  border: 0;
  font-size: 1.6rem;
  font-weight: 100;
  color: #203048;
  line-height: 3rem;
  margin-top: 0.3rem;
  margin-left: 1.4rem;
}

.erach-sport-button {
  width: 2.4rem;
  display: inline-block;
}

.autocomplete-items, #search-sportautocomplete-list {
  background-color: #fff;
  padding-left: 1.4rem;
}

.mapboxgl-popup {
  top: -22px;
}

#js-mapa_height {
  height: 100%;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-direction: column;
      flex-direction: column;
}
@media (min-width: 769px) {
  #js-mapa_height {
    height: 100%;
  }
}

#js-mapa_detail {
  height: 100%;
  display: -ms-flexbox;
  display: flex;
}
@media (min-width: 769px) {
  #js-mapa_detail {
    height: 100%;
  }
}

.row--flex {
  -ms-flex: auto;
      flex: auto;
  display: -ms-flexbox;
  display: flex;
}
@media (min-width: 769px) {
  .row--flex {
    -ms-flex-direction: row;
        flex-direction: row;
  }
}

.container--flex {
  -ms-flex: auto;
      flex: auto;
  display: -ms-flexbox;
  display: flex;
}
@media (min-width: 769px) {
  .container--flex {
    -ms-flex-direction: row;
        flex-direction: row;
  }
}

.sec--mapa {
  overflow: hidden;
  display: -ms-flexbox;
  display: flex;
  max-height: 60vh;
  min-height: 60vh;
}

.btn--close {
  text-align: center;
  color: #203048;
}

#mapa-show {
  height: 100%;
}

.sport_icon {
  width: 69px;
  height: 70px;
  border: 3px solid transparent;
  margin-top: 1.4rem;
  margin-right: 1.4rem;
  margin-bottom: 1.4rem;
  border-radius: 50%;
}
@media only screen and (max-width: 768px) {
  .sport_icon {
    width: 39px;
    height: 40px;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    margin-top: 0.5rem;
  }
}
.sport_icon:hover {
  cursor: pointer;
}

.sport--selected {
  border-color: #027e97;
}

.select {
  margin-left: 3rem;
}

.mapa-tip {
  padding-left: 9.5rem;
  position: relative;
  color: #fff;
  font-size: 1rem;
  line-height: normal;
  background-color: #027e97;
  padding-top: 1.2rem;
  padding-bottom: 1.2rem;
  min-height: 2.5rem;
  min-height: 5rem;
  border-bottom: 2px solid #2d94a9;
  line-height: normal;
}
.mapa-tip::before {
  position: absolute;
  content: "";
  width: 2.3rem;
  height: 2.5rem;
  background-image: url("../img/svg/faq.svg");
  left: 5rem;
  top: 1rem;
  color: #fff;
}

.mapa-show {
  padding-top: 3rem;
  padding-bottom: 3rem;
  padding-left: 5rem;
  padding-right: 4rem;
  overflow: hidden;
  overflow-y: auto;
}

.mapa-show-link {
  display: block;
  margin-bottom: 3rem;
  text-decoration: none;
  position: relative;
}
.mapa-show-link::after {
  content: "";
  position: absolute;
  right: -2rem;
  top: 2.95rem;
  background-image: url("../img/svg/ico-arrow.svg");
  width: 17px;
  height: 30px;
  background-repeat: no-repeat;
}

.mapa-show-link__img {
  float: left;
  display: block;
  margin-right: 4rem;
  width: 8.9rem;
  height: 8.9rem;
  background-repeat: no-repeat;
  background-size: cover;
  border-radius: 50%;
}
@media only screen and (max-width: 991px) {
  .mapa-show-link__img {
    display: none;
  }
}

.mapa-show-link-text__info {
  font-size: 1.3rem;
  padding-bottom: 2rem;
  font-weight: 400;
}

.mapa-show-link-text {
  margin-left: 13rem;
  border-bottom: 1px solid #b3b3b3;
  min-height: 8.9rem;
}
@media only screen and (max-width: 991px) {
  .mapa-show-link-text {
    margin-left: 0;
  }
}

.mapa-show-nacionale__image {
  width: 100%;
  height: auto;
  margin-bottom: 3rem;
}

.mapa-show__adrress {
  font-size: 1.3rem;
  font-weight: 400;
  margin-bottom: 2.5rem;
}

.mapa-show__icons {
  margin-bottom: 3rem;
}
.mapa-show__icons img {
  width: 2.8rem;
  height: auto;
  margin-right: 0.6rem;
}

.mapa-show-nacionale__date, .mapa-show-nacionale__call, .mapa-show-nacionale__web, .mapa-show-nacionale__email {
  position: relative;
  padding-left: 4rem;
  font-size: 1.2rem;
  font-weight: 400;
  line-height: 3rem;
  margin-bottom: 1.5rem;
  color: #757575;
  line-height: 2.6rem;
  overflow: hidden;
}
.mapa-show-nacionale__date::before, .mapa-show-nacionale__call::before, .mapa-show-nacionale__web::before, .mapa-show-nacionale__email::before {
  position: absolute;
  content: "";
  left: 0;
  top: 0;
  background-repeat: no-repeat;
}
.mapa-show-nacionale__date a, .mapa-show-nacionale__call a, .mapa-show-nacionale__web a, .mapa-show-nacionale__email a {
  text-decoration: none;
}

.mapa-show-nacionale__date {
  font-size: 1.3rem;
  font-weight: 700;
  color: #203048;
}
.mapa-show-nacionale__date::before {
  background-image: url("../img/svg/ico-calendar.svg");
  width: 28px;
  height: 25px;
}

.mapa-show-nacionale__call::before {
  background-image: url("../img/svg/ico-call.svg");
  width: 24px;
  height: 24px;
}

.mapa-show-nacionale__web::before {
  background-image: url("../img/svg/ico-web.svg");
  width: 24px;
  height: 24px;
}

.mapa-show-nacionale__email::before {
  background-image: url("../img/svg/ico-email2.svg");
  width: 22px;
  height: 23px;
}

.mapa-show-nacionale__ico::before {
  background-image: url("../img/svg/ico-ico2.svg");
  width: 29px;
  height: 17px;
}

.mapa-mapa-show-content {
  font-size: 1.2rem;
  color: #757575;
  line-height: 2.5rem;
}

.remove-sport-button {
  position: absolute;
  right: 1rem;
  top: 1px;
  font-size: 1.2rem;
  font-weight: 700;
}

.mapa-sport {
  background-color: #027e97;
}

.mapa-sport-list {
  list-style: none;
  margin-left: 3rem;
  display: table;
}
.mapa-sport-list li {
  display: inline-block;
  font-size: 2.1rem;
  font-weight: 400;
  margin-left: 2rem;
  margin-right: 2rem;
}
.mapa-sport-list li a {
  text-decoration: none;
  padding-left: 1rem;
  padding-right: 1rem;
  position: relative;
  color: #fff;
  display: block;
  font-size: 1.9rem;
  padding-top: 1rem;
  padding-bottom: 1rem;
}
.mapa-sport-list li a:hover::after, .mapa-sport-list li a.selected::after {
  position: absolute;
  content: "";
  margin: 0;
  margin-left: auto;
  margin-right: auto;
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid #fff;
  bottom: 0;
  left: 0;
  right: 0;
  text-align: center;
}
.mapa-sport-list li:first-child a {
  margin-left: -1rem;
}

.mapboxgl-popup-content {
  padding: 0;
}

.mapboxgl-obal-obsah {
  /*display: flex;*/
  width: 100%;
}

.mapboxgl-obal-obsah-text {
  width: 100%;
  padding: 1.6rem 1.3rem 0 1.3rem;
}

.mapboxgl-obal-obsah-img {
  width: 40%;
  height: 16rem;
  background-size: cover;
  background-position: center center;
}

a.mapboxgl-obal-obsah-text__button {
  border: 2px solid #02cff7;
  background-color: #fff;
  display: inline-block;
  font-size: 1.1rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #02cff7;
  padding: 0.8rem 1.4rem;
  margin-top: 1rem;
  margin-bottom: 1rem;
  text-decoration: none;
}
a.mapboxgl-obal-obsah-text__button:hover {
  background-color: #02cff7;
  color: #fff;
}

.mapboxgl-obal-obsah-text__adress {
  font-size: 1.3rem;
}

.mapa-back {
  background-color: #001431;
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
  padding-left: 6rem;
}

.mapa-back__link {
  font-size: 1.5rem;
  color: #02cff7;
  font-weight: 700;
  padding: 0.7rem 1.3rem;
  border: 2px solid #02cff7;
  display: inline-block !important;
  cursor: pointer;
}
.mapa-back__link:hover {
  color: #757575;
}

.newsbox {
  width: 100%;
  padding-bottom: 3rem;
}

.newsbox_col {
  border-bottom: 1px solid #027e97;
}

.newsbox--news:hover img {
  transform: scale(1.1);
  transition: transform 0.5s ease;
}
.newsbox--news:hover .attachment-category {
  transform: scale(1.1);
  transition: transform 0.5s ease;
}

.newsbox__date {
  color: #027e97;
  padding-top: 2.3rem;
  margin-bottom: 0.8rem;
  line-height: 1;
}

.title--category {
  color: #000;
  font-size: 1.8rem;
  font-weight: bold;
  margin-bottom: 6rem;
  margin-top: 0;
  padding-top: 0;
}

.newsbox__text {
  line-height: 2.5rem;
  font-size: 1.4rem;
}

.newsbox__link {
  display: block;
  margin: 0;
  width: 100%;
}

.ikonka {
  width: 100%;
  height: 10rem;
  background-color: #f2f2f2;
  position: relative;
}

.ikonka--modra {
  background-color: #003660;
}

.ikonka--kalendar {
  background-color: #203048;
}

.ikonka--zelena {
  background-color: #27e0c0;
}

.ikonka--cervena {
  background-color: #ea0f52;
}

.ikonka--svetla {
  background-color: #63afd0;
}

.ikonka img {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.ctext .title--category {
  padding-top: 2rem;
  color: #ea0f52;
}

.ctext .title--subcategory {
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
}

.newsbox__text {
  line-height: 2.5rem;
  font-size: 1.4rem;
}

.calendar-entry--single {
  background-color: #f2f2f2;
  font-weight: bold;
  padding: 2rem;
  border: 1px solid #027e97;
  margin-bottom: 3rem;
}
.calendar-entry--single span {
  font-weight: normal;
}

.ctext .calendar-entry {
  font-size: 1.5rem;
  line-height: 1.5;
  margin-top: 2rem;
  margin-bottom: 2rem;
}
.ctext .calendar-entry div {
  display: block;
  font-weight: bold;
}
.ctext .calendar-entry span {
  color: #027e97;
  font-weight: normal;
}

a.newsbox__link {
  text-decoration: none;
  display: block;
  overflow: hidden;
  clear: both;
}
a.newsbox__link:hover {
  text-decoration: none;
}
a.newsbox__link:hover a {
  text-decoration: underline !important;
}

a.newsbox__link:hover a {
  text-decoration: underline !important;
}

a.newsbox__link:hover span.underline {
  text-decoration: underline !important;
}

.ikonka--svetla {
  background-color: #63afd0;
}

.select-css {
  display: block;
  font-size: 16px;
  font-family: sans-serif;
  font-weight: 700;
  color: #444;
  line-height: 1.35;
  padding: 0.6em 1.4em 0.5em 0.8em;
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
  margin: 0;
  border: 1px solid #aaa;
  box-shadow: 0 1px 0 1px rgba(0, 0, 0, 0.04);
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-color: #f2f2f2;
  background-image: url(data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E), linear-gradient(to bottom, #ffffff 0%, #e5e5e5 100%);
  background-repeat: no-repeat, repeat;
  background-position: right 0.7em top 50%, 0 0;
  background-size: 0.65em auto, 100%;
}

.slick-initialized .slick-slide {
  max-height: 434px;
}

/* Slider */
.slick-slider {
  position: relative;
  display: block;
  box-sizing: border-box;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -ms-touch-action: pan-y;
  touch-action: pan-y;
  -webkit-tap-highlight-color: transparent;
}
@media only screen and (max-width: 600px) {
  .slick-slider {
    height: 196px;
  }
}
@media only screen and (min-width: 601px) and (max-width: 844px) {
  .slick-slider {
    height: 270px;
  }
}
@media only screen and (min-width: 845px) and (max-width: 991px) {
  .slick-slider {
    height: 366px;
  }
}

.slick-list {
  position: relative;
  overflow: hidden;
  display: block;
  margin: 0;
  padding: 0;
}

.slick-list:focus {
  outline: none;
}

.slick-list.dragging {
  cursor: pointer;
  cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list {
  transform: translate3d(0, 0, 0);
}

.slick-track {
  position: relative;
  left: 0;
  top: 0;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.slick-track:before, .slick-track:after {
  content: "";
  display: table;
}

.slick-track:after {
  clear: both;
}

.slick-loading .slick-track {
  visibility: hidden;
}

.slick-slide {
  float: left;
  height: 100%;
  min-height: 1px;
  display: none;
}

[dir=rtl] .slick-slide {
  float: right;
}

.slick-slide img {
  display: block;
}

.slick-slide.slick-loading img {
  display: none;
}

.slick-slide.dragging img {
  pointer-events: none;
}

.slick-initialized .slick-slide {
  display: block;
}

.slick-loading .slick-slide {
  visibility: hidden;
}

.slick-vertical .slick-slide {
  display: block;
  height: auto;
  border: 1px solid transparent;
}

.slick-arrow.slick-hidden {
  display: none;
}

.slider {
  line-height: 0;
}

@media only screen and (max-width: 767px) {
  .slider {
    line-height: normal;
  }
}
.slider-item img {
  width: 100%;
  height: auto;
}

.slider-item-text {
  position: absolute;
  z-index: 99999;
  bottom: 0rem;
  width: 100%;
  padding-top: 1.7rem;
  padding-bottom: 2.3rem;
  padding-left: 3.2rem;
  padding-right: 3.2rem;
  color: #fff;
  font-size: 1.3rem;
}

@media only screen and (max-width: 767px) {
  .slider-item-text {
    position: relative;
    min-height: 20rem;
  }
}
.slick-active .slider-item-text {
  background-color: #003660;
}

.slider-item-text__first {
  margin-bottom: 1.3rem;
  width: 100%;
}

.slider-item-text__first span {
  text-transform: uppercase;
  color: #fff;
  font-size: 1.5rem;
  line-height: 1.434rem;
  /*display: inline-block;*/
  margin-bottom: 0.5rem;
}

.slider-item-text__first span a {
  color: #fff;
  text-decoration: underline;
  text-transform: none;
}

.slider-item-text__first span a:hover {
  text-decoration: none;
}

.tslider {
  font-size: 1.3rem;
}

.tslider-link {
  background-color: #027E97;
  text-decoration: none;
  color: white;
  display: block;
  width: 100%;
  margin-bottom: 2.8px;
  line-height: 1;
  overflow: hidden;
  height: 107px;
  max-height: 107px;
}

.tslider-link--more {
  background-color: #003660;
  display: block;
  width: 100%;
  color: #fff;
  font-size: 1.6rem;
}

.tslider-link__date {
  text-transform: uppercase;
  padding-top: 1rem;
  margin-left: 3.5rem;
  margin-right: 3.5rem;
  margin-bottom: 1rem;
}

@media only screen and (min-width: 991px) and (max-width: 1199px) {
  .tslider-link__date {
    padding-top: 1.2rem;
  }
}
.tslider-link--more {
  padding-left: 3.5rem;
}

.tslider-link:hover {
  color: white;
  background: #003660;
}

@media only screen and (max-width: 990px) {
  .tslider-link--more {
    line-height: 7rem;
  }
}
.sliderbox {
  position: relative;
  z-index: 10;
}

.sliderbox .slider-item {
  height: 70rem;
  background-size: cover;
  width: 100%;
  position: relative;
}

.slider-item-text__first {
  /*width: 80%;*/
}

.strip {
  width: 25%;
  display: none;
  position: absolute;
  top: 0;
  right: 0;
  background-color: #fff;
}

@media only screen and (max-width: 767px) {
  .strip {
    position: relative;
    width: 100%;
  }
}
.slick-dots {
  position: absolute;
  bottom: 0.5rem;
  display: block;
  width: 100%;
  padding: 0;
  margin: 0;
  list-style: none;
  text-align: center;
}

.slick-dots li {
  position: relative;
  display: inline-block;
  width: 20px;
  height: 20px;
  margin: 0 5px;
  padding: 0;
  cursor: pointer;
}

.slick-dots li button {
  font-size: 0;
  line-height: 0;
  display: block;
  width: 20px;
  height: 20px;
  padding: 5px;
  cursor: pointer;
  color: transparent;
  border: 0;
  outline: none;
  background: transparent;
}

.slick-dots li button:before {
  color: black;
  font-family: "slick";
  font-size: 5rem;
  line-height: 20px;
  position: absolute;
  top: 0;
  left: 0;
  width: 20px;
  height: 20px;
  content: "•";
  text-align: center;
  color: white;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  z-index: 99999;
}

.slick-prev, .slick-next {
  font-size: 0;
  line-height: 0;
  position: absolute;
  top: 50%;
  display: block;
  width: 20px;
  height: 20px;
  padding: 0;
  transform: translate(0, -50%);
  cursor: pointer;
  color: black;
  border: none;
  outline: none;
  background: transparent;
  z-index: 99999;
}
@media only screen and (max-width: 991px) {
  .slick-prev, .slick-next {
    display: none !important;
  }
}

.slick-prev {
  left: 1.5rem;
}

.slick-next {
  right: 1.5rem;
}

.slick-prev:hover, .slick-prev:focus, .slick-next:hover, .slick-next:focus {
  color: transparent;
  outline: none;
  background: transparent;
}

.slick-prev:before, .slick-next:before {
  font-family: "slick";
  font-size: 5rem;
  line-height: 1;
  opacity: 1;
  color: black;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.slick-prev:before {
  content: "<";
}

.slick-prev:hover:before, .slick-prev:focus:before, .slick-next:hover:before, .slick-next:focus:before {
  opacity: 1;
}

.slick-next:before {
  content: ">";
}

.title--slider {
  font-size: 1.6rem;
  font-weight: 700;
  line-height: 2.1rem;
  /*display: inline-block;*/
  color: #fff;
  margin: 0;
  /*margin-left: 2.8rem;*/
  margin-top: 0.7rem;
  margin-bottom: 0.7rem;
}

@media only screen and (max-width: 768px) {
  .title--slider {
    margin-left: 0;
    margin-top: 0.5rem;
  }
}
.title--slider a {
  color: #fff;
  text-decoration: none;
}

.title--tslider {
  font-size: 1.4rem;
  font-weight: 700;
  margin-left: 3.5rem;
  margin-right: 3.5rem;
  margin-bottom: 1rem;
  margin-top: 0.2rem;
  color: #fff;
}

@media only screen and (min-width: 991px) and (max-width: 1201px) {
  .title--tslider {
    margin-top: 0.5rem;
  }
}
/* dots */
.slick-dots li.slick-active button::before {
  color: #027E97 !important;
  opacity: 1;
}

.slick-prev:before, .slick-next:before {
  color: white !important;
}

button.slick-next.slick-arrow {
  color: white;
}

.slider-active {
  background-color: #003660;
}

.sec--slider {
  overflow: hidden;
}

</style>
  </head>
<body class="mx-lg-4>

<a href="" class="none">Skip to menu</a>
  <a href="" class="none">Skip to content</a>
  <header>
    <div class="bar">
    <?php get_search_form(); ?>

    <?php
    $social_media = get_field("social_media", "option");

    if ($social_media): ?>
  <div class="bar__ico">
    <?php
    $default_target = "_self";

    if (!empty($social_media["instagram"]["url"])):
    	$target = !empty($social_media["instagram"]["target"])
    		? $social_media["instagram"]["target"]
    		: $default_target; ?>
      <a href="<?php echo esc_url(
      	$social_media["instagram"]["url"]
      ); ?>" class="bar__ico__img bar__ico__img--instagram" aria-label="Instagram" target="<?php echo esc_attr(
	$target
); ?>" rel="noopener noreferrer">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"  aria-labelledby="instagram">
            <title id="instagram">Instagram</title>
            <g clip-path="url(#clip0_114_950)">
              <path d="M19.9861 40C8.95357 40 0 31.0464 0 20.0139C0 8.95357 8.95357 0 19.9861 0C31.0187 0 39.9723 8.95357 39.9723 19.9861C39.9723 31.0187 31.0187 39.9723 19.9861 39.9723V40Z" fill="white"/>
              <path d="M19.9861 11.0049C22.9245 11.0049 23.2571 11.0049 24.4214 11.0603C25.5024 11.1157 26.0846 11.2821 26.4449 11.4484C26.9439 11.6424 27.332 11.8919 27.6923 12.28C28.0804 12.6681 28.3022 13.0284 28.5239 13.5274C28.6625 13.9155 28.8566 14.4976 28.912 15.5509C28.9674 16.7152 28.9674 17.0478 28.9674 19.9861C28.9674 22.9245 28.9674 23.2571 28.912 24.4214C28.8566 25.5024 28.6902 26.0846 28.5239 26.4449C28.3299 26.9439 28.0804 27.332 27.6923 27.6923C27.3042 28.0804 26.9439 28.3022 26.4449 28.5239C26.0568 28.6625 25.4747 28.8566 24.4214 28.912C23.2571 28.9674 22.9245 28.9674 19.9861 28.9674C17.0478 28.9674 16.7152 28.9674 15.5509 28.912C14.4699 28.8566 13.8877 28.6902 13.5274 28.5239C13.0284 28.3299 12.6403 28.0804 12.28 27.6923C11.8919 27.3042 11.6701 26.9439 11.4484 26.4449C11.3098 26.0568 11.1157 25.4747 11.0603 24.4214C11.0049 23.2571 11.0049 22.9245 11.0049 19.9861C11.0049 17.0478 11.0049 16.7152 11.0603 15.5509C11.1157 14.4699 11.2821 13.8877 11.4484 13.5274C11.6424 13.0284 11.8919 12.6403 12.28 12.28C12.6681 11.8919 13.0284 11.6701 13.5274 11.4484C13.9155 11.3098 14.4976 11.1157 15.5509 11.0603C16.7152 11.0049 17.0478 11.0049 19.9861 11.0049ZM19.9861 9.03674C17.0201 9.03674 16.632 9.03674 15.4678 9.09218C14.3035 9.14762 13.4997 9.34166 12.8067 9.59114C12.0859 9.86834 11.4761 10.2564 10.8663 10.8663C10.2564 11.4761 9.86834 12.0859 9.59114 12.8067C9.31394 13.4997 9.14762 14.3035 9.09218 15.4678C9.03674 16.632 9.03674 17.0201 9.03674 19.9861C9.03674 22.9522 9.03674 23.3403 9.09218 24.5045C9.14762 25.6688 9.34166 26.4726 9.59114 27.1656C9.86834 27.8864 10.2564 28.4962 10.8663 29.106C11.4761 29.7159 12.0859 30.104 12.8067 30.3812C13.4997 30.6584 14.3035 30.8247 15.4678 30.8801C16.632 30.9356 17.0201 30.9356 19.9861 30.9356C22.9522 30.9356 23.3403 30.9356 24.5045 30.8801C25.6688 30.8247 26.4726 30.6306 27.1656 30.3812C27.8864 30.104 28.4962 29.7159 29.106 29.106C29.7159 28.4962 30.104 27.8864 30.3812 27.1656C30.6584 26.4726 30.8247 25.6688 30.8801 24.5045C30.9356 23.3403 30.9356 22.9522 30.9356 19.9861C30.9356 17.0201 30.9356 16.632 30.8801 15.4678C30.8247 14.3035 30.6306 13.4997 30.3812 12.8067C30.104 12.0859 29.7159 11.4761 29.106 10.8663C28.4962 10.2564 27.8864 9.86834 27.1656 9.59114C26.4726 9.31394 25.6688 9.14762 24.5045 9.09218C23.3403 9.03674 22.9522 9.03674 19.9861 9.03674Z" fill="#00345F"/>
              <path d="M19.9862 14.359C16.8815 14.359 14.359 16.8815 14.359 19.9862C14.359 23.0908 16.8815 25.6133 19.9862 25.6133C23.0908 25.6133 25.6133 23.0908 25.6133 19.9862C25.6133 16.8815 23.0908 14.359 19.9862 14.359ZM19.9862 23.6452C17.9626 23.6452 16.3271 22.0097 16.3271 19.9862C16.3271 17.9626 17.9626 16.3271 19.9862 16.3271C22.0097 16.3271 23.6452 17.9626 23.6452 19.9862C23.6452 22.0097 22.0097 23.6452 19.9862 23.6452Z" fill="#00345F"/>
              <path d="M27.1656 14.1373C27.1656 14.858 26.5835 15.4401 25.8628 15.4401C25.1421 15.4401 24.5599 14.858 24.5599 14.1373C24.5599 13.4165 25.1421 12.8344 25.8628 12.8344C26.5835 12.8344 27.1656 13.4165 27.1656 14.1373Z" fill="#00345F"/>
            </g>
            <defs>
            <clipPath id="clip0_114_950">
            <rect width="40" height="40" fill="white"/>
            </clipPath>
            </defs>
          </svg>
      </a>
    <?php
    endif;
    ?>

    <?php if (!empty($social_media["facebook"]["url"])):
    	$target = !empty($social_media["facebook"]["target"])
    		? $social_media["facebook"]["target"]
    		: $default_target; ?>
      <a href="<?php echo esc_url(
      	$social_media["facebook"]["url"]
      ); ?>" class="bar__ico__img bar__ico__img--facebook" aria-label="Facebook" target="<?php echo esc_attr(
	$target
); ?>" rel="noopener noreferrer">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none" aria-labelledby="facebook">
            <title id="facebook">Facebook</title>
            <g clip-path="url(#clip0_114_959)">
              <path d="M19.9861 40C8.95357 40 0 31.0464 0 20.0139C0 8.95357 8.95357 0 19.9861 0C31.0187 0 39.9723 8.95357 39.9723 19.9861C39.9723 31.0187 31.0187 39.9723 19.9861 39.9723V40Z" fill="white"/>
              <path d="M17.0478 31.6285H21.9265V19.4317H25.3084L25.6687 15.3569H21.8988V13.0284C21.8988 12.0582 22.0928 11.6978 23.0353 11.6978H25.6687V7.45667H22.2869C18.6556 7.45667 17.0201 9.06443 17.0201 12.1136V15.3569H14.4976V19.4872H17.0201V31.6285H17.0478Z" fill="#00345F"/>
            </g>
            <defs>
            <clipPath id="clip0_114_959">
            <rect width="40" height="40" fill="white"/>
            </clipPath>
            </defs>
          </svg>
      </a>
    <?php
    endif; ?>

    <?php if (!empty($social_media["mail"])): ?>
      <a href="mailto:<?php echo esc_attr(
      	$social_media["mail"]
      ); ?>" class="bar__ico__img bar__ico__img--email" aria-label="Email" target="<?php echo esc_attr(
	$default_target
); ?>">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none" aria-labelledby="email">
            <title id="email">E-mail</title>
            <path d="M20 40C8.95978 40 0 31.0464 0 20.0139C0 8.95357 8.95978 0 20 0C31.0402 0 40 8.95357 40 19.9861C40 31.0187 31.0402 39.9723 20 39.9723V40Z" fill="white"/>
            <path d="M30.3189 11.282H9.90286C8.71007 11.282 7.7392 12.2522 7.7392 13.4442V26.5003C7.7392 27.6923 8.71007 28.6625 9.90286 28.6625H30.3189C31.5117 28.6625 32.4826 27.6923 32.4826 26.5003V13.4442C32.4826 12.2522 31.5117 11.282 30.3189 11.282ZM29.9861 12.7512C29.2926 13.4442 21.0263 21.7602 20.6657 22.0929C20.3883 22.3701 19.8335 22.3701 19.5284 22.0929L10.208 12.7512H29.9583H29.9861ZM9.1539 26.2509V13.7214L15.3952 19.9861L9.1539 26.2509ZM10.2357 27.2488L16.4493 21.0118L18.5298 23.0908C19.3897 23.9501 20.8599 23.9501 21.7198 23.0908L23.8002 21.0118L30.0138 27.2488H10.2357ZM31.0402 26.2509L24.7988 19.9861L31.0402 13.7214V26.2509Z" fill="#00345F"/>
          </svg>
      </a>
    <?php endif; ?>
  </div>
<?php endif;
    ?>


    </div>















    <div class="topmenu">
      <div class="topmenu__left">
        <div class="topmenu__logo">
          <a href="<?php echo home_url(); ?>" class="topmenu__logo__link" aria-label="Návrat na úvodní stránku">
            <img src="<?php echo get_template_directory_uri() .
            	"/images/logo-fajnovysport.png"; ?>" alt="logo fajnový sport - oficiální stránky města Ostravy v oblasti sportu" />
          </a>
        </div>
        <div class="topmenu__nav">
        <?php wp_nav_menu([
        	"theme_location" => "menu-1",
        	"menu_class" => "nav",
        	"container" => "nav",
        	"container_class" => "nav-container",
        ]); ?>
        </div>
      </div>
      <div class="topmenu__right">
        <a href="" class="viewmap">
          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="50" viewBox="0 0 45 50" fill="none" class="viewmap__ico" aria-labelledby="viewmapIco">
            <title id="viewmapIco">Pin</title>
            <path d="M22.0248 0.678955C13.796 0.678955 7.14246 7.3597 7.14246 15.5884C7.14246 21.8075 15.6428 34.4357 19.7979 40.2203C20.8842 41.7411 23.1654 41.7411 24.2517 40.2203C28.4068 34.4357 36.9071 21.8075 36.9071 15.5884C36.9342 7.3597 30.2535 0.678955 22.0248 0.678955ZM22.0248 21.5631C18.277 21.5631 15.2626 18.5214 15.2626 14.8009C15.2626 11.0803 18.3042 8.03864 22.0248 8.03864C25.7454 8.03864 28.787 11.0803 28.787 14.8009C28.787 18.5214 25.7454 21.5631 22.0248 21.5631Z" fill="white"/>
            <path opacity="0.5" d="M22.3235 47.933C28.248 47.933 33.0508 47.0211 33.0508 45.8962C33.0508 44.7713 28.248 43.8594 22.3235 43.8594C16.3991 43.8594 11.5963 44.7713 11.5963 45.8962C11.5963 47.0211 16.3991 47.933 22.3235 47.933Z" fill="white"/>
          </svg>
          <span class="viewmap__text">Zobrazit mapu sportovišť</span>
        </a>
      </div>
    </div>
  </header>

<?php get_template_part("template-parts/content", "breadcrumbs"); ?>

  <main class="content" role="main">

