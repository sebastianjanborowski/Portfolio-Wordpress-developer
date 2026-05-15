<?php
defined('ABSPATH') || exit;

/**
 * My Account wrapper (theme override)
 * - niezalogowany: formularz logowania + rejestracji (jeśli włączona)
 * - zalogowany: nawigacja + content
 */

if ( ! is_user_logged_in() ) {

  /**
   * WooCommerce sam pokaże login + rejestrację
   * Warunek rejestracji zależy od ustawień:
   * WooCommerce -> Ustawienia -> Konta i prywatność -> "Włącz rejestrację..."
   */
  wc_get_template( 'myaccount/form-login.php' );

} else {

  /**
   * Standardowy układ My Account
   * (Twoje wrappery/hero masz już robione hookami w functions.php)
   */
  do_action( 'woocommerce_account_navigation' );
  do_action( 'woocommerce_account_content' );

}