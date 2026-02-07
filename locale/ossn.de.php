<?php
/**
 * Open Source Social Network
 *
 * @package   Wallet
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (c) Engr. Syed Arsalan Hussain Shah (OpenTeknik LLC)
 * @license   OpenTeknik LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */
ossn_register_languages('de', array(
	'wallet'                              => 'Brieftasche',
	'wallet:overview'                     => 'Brieftasche Übersicht',
	'wallet:current:balance'              => 'Aktueller Kontostand',
	'wallet:history'                      => 'Verlauf',
	'wallet:date'                         => 'Datum',
	'wallet:amount'                       => 'Betrag',
	'wallet:type'                         => 'Typ',
	'wallet:description'                  => 'Beschreibung',
	'wallet:addbalance'                   => 'Guthaben aufladen',
	'wallet:charge:paypal'                => 'Brieftasche mit PayPal aufladen',
	'wallet:charge:balance:note'          => 'Sie können Ihr Wallet aufladen. Sie können eine der untenstehenden Methoden verwenden.',
	'wallet:charge:amount:paypal'         => 'Betrag eingeben (Minimum %s %s)',
	'wallet:charge:failed'                => 'Wallet-Aufladung fehlgeschlagen',
	'wallet:charge:failed:note'           => 'Das Wallet kann momentan nicht aufgeladen werden. Dies kann verschiedene Gründe haben. Bitte kontaktieren Sie den Kundendienst für weitere Informationen.',
	'wallet:charge:paypal:success'        => 'Wallet erfolgreich aufgeladen!',
	'wallet:charge:paypal:failed'         => 'Aufladung fehlgeschlagen',
	'wallet:paynow'                       => 'Jetzt bezahlen',
	'wallet:admin:paypal'                 => 'PayPal',
	'wallet:admin:paypal:client:id'       => 'Client-ID',
	'wallet:admin:paypal:client:secret'   => 'Client-Geheimnis',
	'wallet:admin:settings:saved'         => 'Einstellungen gespeichert',
	'wallet:admin:settings:save:error'    => 'Einstellungen können momentan nicht gespeichert werden!',
	'wallet:charge:min'                   => 'Ihr Betrag liegt unter dem erforderlichen Mindestbetrag!',

	'wallet:admin:stripe'                 => 'Stripe',
	'wallet:admin:stripe:publishable:key' => 'Öffentlicher Schlüssel',
	'wallet:admin:stripe:secret:key'      => 'Geheimer Schlüssel',
	'wallet:admin:payment:methods'        => 'Zahlungsmethoden',
	'wallet:charge:card'                  => 'Per Karte aufladen',
	'wallet:card:holder'                  => 'Karteninhaber',
	'wallet:card:number'                  => 'Kartennummer',
	'wallet:card:process'                 => 'Die Karte wird verarbeitet, bitte warten...',
	'wallet:notconfigured:note'           => 'Wallet-Dienste sind nicht konfiguriert. Bitte informieren Sie den Website-Administrator!',
	'wallet:method:not:enabled'           => 'Methode nicht aktiviert!',

	'wallet:change:user:balance'          => 'Kontostand ändern',
	'wallet:alter:type'                   => 'Typ ändern',
	'wallet:alter:type:entier'            => 'Gesamten Kontostand ändern',
	'wallet:alter:type:debit'             => 'Belasten (Abziehen)',
	'wallet:alter:type:credit'            => 'Gutschrift (Hinzufügen)',
	'wallet:alter:amount'                 => 'Betrag',

	'wallet:charge:iyzipay'               => 'Iyzipay',
	'wallet:admin:iyzipay'                => 'Iyzipay (Iyzico)',
	'wallet:admin:iyzipay:key'            => 'API-Schlüssel',
	'wallet:admin:iyzipay:secret:key'     => 'Geheimer Schlüssel',
	'wallet:admin:iyzipay:mode'           => 'Nutzungsmodus',
	'wallet:iyzipay:city'                 => 'Stadt',
	'wallet:iyzipay:address'              => 'Adresse',
	'wallet:iyzipay:country'              => 'Land',
	'wallet:iyzipay:zipcode'              => 'Postleitzahl',
	'wallet:iyzipay:identity'             => 'Identifikationsnummer',
	'wallet:iyzipay:loading'              => 'Lädt...Bitte warten!',

	'wallet:savepayment:method'           => 'Karte sicher speichern für nahtlose Zahlungen',
	'wallet:savepayment:method:note'      => 'Durch das sichere Speichern Ihrer Kartendaten kann unser System Zahlungen automatisch verarbeiten, wenn fällig. Ihre Daten sind verschlüsselt und geschützt.',
	'wallet:addcard'                       => 'Kredit-/Debitkarte hinzufügen',
	'wallet:seamnless:charge:head'        => 'Verifizierungsgebühr Hinweis!',
	'wallet:saveseamless:testcharge:note' => 'Zur Sicherheitsüberprüfung wird ein einmaliger Betrag von %s %s erhoben. Dieser wird Ihrem Wallet gutgeschrieben und kann für zukünftige Käufe genutzt werden. Keine zusätzlichen Gebühren.',
	'wallet:seamlesscharge:credit'        => 'Wallet-Verifizierungsgebühr gutgeschrieben!',
	'wallet:charge:failed:seamless:head'  => 'Ihre Karte konnte für automatische Zahlungen nicht eingerichtet werden.',
	'wallet:charge:failed:seamless:note'  => 'Der Vorgang konnte nicht abgeschlossen werden. Gründe können Kartenbeschränkungen oder Banklimits sein. Einige Karten unterstützen keine automatischen Zahlungen.',
	'wallet:makesure:delete:seamless'     => 'Sind Sie sicher, dass Sie diese Karte löschen möchten?',
	'wallet:paymentmethod:remove:failed'  => 'Karte konnte nicht entfernt werden. Bitte später erneut versuchen oder Support kontaktieren!',
	'wallet:paymentmethod:removed'        => 'Karte wurde entfernt!',
	'wallet:seamless:blocked'             => 'Ihre Zahlungsmethode wurde nach mehreren Fehlversuchen vorübergehend blockiert. Kontaktieren Sie den Administrator %s, um sie zu aktualisieren.',

	'wallet:admin:overview'               => 'Übersicht',
	'wallet:admin:gateways'               => 'Zahlungsgateways',
	'wallet:admin:blocked'                => 'Gesperrte Nutzer',
	'walet:delete:seamless:note:block'    => 'Wenn die Karte eines Nutzers nach drei Fehlversuchen blockiert wird, kann er keine Karten hinzufügen oder entfernen. Nur Admins können die Karte löschen.',
	'wallet:tran:status:success'          => 'Erfolgreich',
	'wallet:tran:status:failed'           => 'Fehlgeschlagen',
	'wallet:tran:notification:debit'      => 'Wallet-Debit-Transaktion - %s',
	'wallet:tran:notification:credit'     => 'Wallet-Guthaben-Transaktion - %s',
	'wallet:tran:debit:notification:body' => "Lieber Nutzer,

Eine Transaktion wurde auf Ihrem Wallet durchgeführt:

Typ: %s
Status: %s
Betrag: %s
Beschreibung: %s

Vielen Dank,
Bitte antworten Sie nicht auf diese E-Mail.",
	'wallet:billingaddress'               => 'Rechnungsadresse',
	'wallet:billingaddress:country'       => 'Land',
	'wallet:billingaddress:select'        => 'Auswählen',
	'wallet:billingaddress:city'          => 'Stadt',
	'wallet:billingaddress:postal'        => 'Postleitzahl',
	'wallet:billingaddress:address'       => 'Adresse (Zeile 1, z. B. Wohnung, Suite, Einheit oder Gebäude)',
	'wallet:billing:fieldsrequired'       => 'Bitte füllen Sie alle Rechnungsfelder aus.',
	'wallet:billing:saved'                => 'Einstellungen gespeichert',
	'wallet:billing:save:error'           => 'Einstellungen konnten nicht gespeichert werden',
	'wallet:billing:invalid_postal'       => 'Ungültige Postleitzahl!',
	'wallet:billingaddress:state'         => 'Bundesland',
	'wallet:error:taxamountempty'         => 'Steuerbetrag darf nicht leer sein! Bitte kontaktieren Sie den Systemadministrator!',
	'wallet:taxsettings'                  => 'Steuereinstellungen',
	'wallet:admn:tax:note'                => 'Die Steueroption ist nur bei Verwendung von Stripe verfügbar. „Exklusiv“ bedeutet, dass die Steuer zum Gesamtpreis hinzugerechnet wird, „Inklusiv“ bedeutet, dass die Steuer bereits enthalten ist. Bei Aktivierung muss der Nutzer die Adresse angeben.',
	'wallet:admn:taxenable'               => 'Steuer aktivieren',
	'wallet:admn:taxtype'                 => 'Steuerart',
));
