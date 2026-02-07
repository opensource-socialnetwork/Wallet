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
ossn_register_languages('fr', array(
	'wallet'                              => 'Portefeuille',
	'wallet:overview'                     => 'Aperçu du portefeuille',
	'wallet:current:balance'              => 'Solde actuel',
	'wallet:history'                      => 'Historique',
	'wallet:date'                         => 'Date',
	'wallet:amount'                       => 'Montant',
	'wallet:type'                         => 'Type',
	'wallet:description'                  => 'Description',
	'wallet:addbalance'                   => 'Recharger le solde',
	'wallet:charge:paypal'                => 'Recharger votre portefeuille via PayPal',
	'wallet:charge:balance:note'          => 'Vous pouvez recharger votre portefeuille. Vous pouvez utiliser l’une des méthodes ci-dessous.',
	'wallet:charge:amount:paypal'         => 'Entrez le montant (Minimum %s %s)',
	'wallet:charge:failed'                => 'Échec de la recharge du portefeuille',
	'wallet:charge:failed:note'           => 'Le portefeuille ne peut pas être rechargé pour le moment. Cela peut être dû à plusieurs raisons, veuillez contacter le support client pour plus de détails.',
	'wallet:charge:paypal:success'        => 'Le portefeuille a été rechargé avec succès !',
	'wallet:charge:paypal:failed'         => 'La recharge a échoué',
	'wallet:paynow'                       => 'Payer maintenant',
	'wallet:admin:paypal'                 => 'PayPal',
	'wallet:admin:paypal:client:id'       => 'ID Client',
	'wallet:admin:paypal:client:secret'   => 'Secret Client',
	'wallet:admin:settings:saved'         => 'Les paramètres ont été enregistrés',
	'wallet:admin:settings:save:error'    => 'Les paramètres ne peuvent pas être enregistrés pour le moment !',
	'wallet:charge:min'                   => 'Votre montant est inférieur au montant minimum requis !',

	'wallet:admin:stripe'                 => 'Stripe',
	'wallet:admin:stripe:publishable:key' => 'Clé publiable',
	'wallet:admin:stripe:secret:key'      => 'Clé secrète',
	'wallet:admin:payment:methods'        => 'Méthodes de paiement',
	'wallet:charge:card'                  => 'Recharger via carte',
	'wallet:card:holder'                  => 'Titulaire de la carte',
	'wallet:card:number'                  => 'Numéro de carte',
	'wallet:card:process'                 => 'La carte est en cours de traitement, veuillez patienter.....',
	'wallet:notconfigured:note'           => 'Les services de portefeuille ne sont pas configurés, veuillez en informer l’administrateur du site !',
	'wallet:method:not:enabled'           => 'Méthode non activée !',

	'wallet:change:user:balance'          => 'Modifier le solde',
	'wallet:alter:type'                   => 'Changer le type',
	'wallet:alter:type:entier'            => 'Changement du solde total',
	'wallet:alter:type:debit'             => 'Débit (Retirer)',
	'wallet:alter:type:credit'            => 'Crédit (Ajouter)',
	'wallet:alter:amount'                 => 'Montant',

	'wallet:charge:iyzipay'               => 'Iyzipay',
	'wallet:admin:iyzipay'                => 'Iyzipay (Iyzico)',
	'wallet:admin:iyzipay:key'            => 'Clé API',
	'wallet:admin:iyzipay:secret:key'     => 'Clé secrète',
	'wallet:admin:iyzipay:mode'           => 'Mode d’utilisation',
	'wallet:iyzipay:city'                 => 'Ville',
	'wallet:iyzipay:address'              => 'Adresse',
	'wallet:iyzipay:country'              => 'Pays',
	'wallet:iyzipay:zipcode'              => 'Code postal',
	'wallet:iyzipay:identity'             => 'Numéro d’identité',
	'wallet:iyzipay:loading'              => 'Chargement...Veuillez patienter !',
	
	'wallet:savepayment:method'           => 'Enregistrez votre carte en toute sécurité pour des paiements sans effort',
	'wallet:savepayment:method:note'      => 'En enregistrant vos informations de carte de manière sécurisée, notre système pourra traiter automatiquement les paiements lorsque nécessaire. Vos informations sont chiffrées et protégées selon les standards de sécurité de l’industrie.',
	'wallet:addcard'                       => 'Ajouter une carte de crédit/débit',
	'wallet:seamnless:charge:head'        => 'Avis de charge de vérification !',
	'wallet:saveseamless:testcharge:note' => 'Dans le cadre de nos mesures de sécurité, un prélèvement unique de %s %s sera appliqué pour vérifier votre nouvelle méthode de paiement. Ce montant sera crédité sur votre portefeuille et pourra être utilisé pour vos achats futurs. Aucuns frais supplémentaires ne seront appliqués et vos données sont protégées.',
	'wallet:seamlesscharge:credit'        => 'Crédit de vérification du portefeuille !',
	'wallet:charge:failed:seamless:head'  => 'Nous n’avons pas pu configurer votre carte pour des paiements automatiques.',
	'wallet:charge:failed:seamless:note'  => 'Le processus n’a pas pu être complété pour le moment. Cela peut être dû à des restrictions de votre banque. Certains cartes ne supportent pas les paiements automatiques.',
	'wallet:makesure:delete:seamless'     => 'Êtes-vous sûr de vouloir supprimer cette carte ?',
	'wallet:paymentmethod:remove:failed'  => 'Impossible de supprimer la carte, veuillez réessayer plus tard ou contacter le support !',
	'wallet:paymentmethod:removed'        => 'La carte a été supprimée !',
	'wallet:seamless:blocked'             => 'Votre méthode de paiement a été temporairement bloquée après plusieurs tentatives échouées. Pour la mettre à jour, contactez l’administrateur %s.',

	'wallet:admin:overview'               => 'Aperçu',
	'wallet:admin:gateways'               => 'Passerelles',
	'wallet:admin:blocked'                => 'Utilisateurs bloqués',
	'walet:delete:seamless:note:block'    => 'Si la carte d’un utilisateur est bloquée après trois tentatives échouées, il ne pourra pas ajouter ou supprimer de cartes. Seuls les admins peuvent supprimer une carte bloquée.',
	'wallet:tran:status:success'          => 'Réussi',
	'wallet:tran:status:failed'           => 'Échoué',
	'wallet:tran:notification:debit'      => 'Transaction de débit du portefeuille - %s',
	'wallet:tran:notification:credit'     => 'Transaction de crédit du portefeuille - %s',
	'wallet:tran:debit:notification:body' => "Cher membre,

Une transaction a été effectuée sur votre portefeuille :

Type : %s
Statut : %s
Montant : %s
Description : %s

Merci,
Veuillez ne pas répondre à cet e-mail.",
	'wallet:billingaddress'               => 'Adresse de facturation',
	'wallet:billingaddress:country'       => 'Pays',
	'wallet:billingaddress:select'        => 'Sélectionner',
	'wallet:billingaddress:city'          => 'Ville',
	'wallet:billingaddress:postal'        => 'Code postal',
	'wallet:billingaddress:address'       => 'Adresse (ligne 1, appartement, suite, unité ou bâtiment)',
	'wallet:billing:fieldsrequired'       => 'Veuillez remplir tous les champs de facturation.',
	'wallet:billing:saved'                => 'Paramètres enregistrés',
	'wallet:billing:save:error'           => 'Impossible d’enregistrer les paramètres',
	'wallet:billing:invalid_postal'       => 'Code postal invalide !',
	'wallet:billingaddress:state'         => 'État',
	'wallet:error:taxamountempty'         => 'Le montant de la taxe ne peut pas être vide ! Veuillez contacter l’administrateur du système !',
	'wallet:taxsettings'                  => 'Paramètres fiscaux',
	'wallet:admn:tax:note'                => 'L’option fiscale est disponible uniquement avec Stripe. "Exclusif" signifie que la taxe s’ajoute au prix total, "Inclusif" signifie que la taxe est déjà incluse. Cette option peut nécessiter la saisie de l’adresse par l’utilisateur.',
	'wallet:admn:taxenable'               => 'Activer la taxe',
	'wallet:admn:taxtype'                 => 'Type de taxe',
));
