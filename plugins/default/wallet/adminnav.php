<nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item d-none">
          <a class="nav-link" href="<?php echo ossn_site_url("administrator/component/Wallet");?>"><i class="fas fa-list"></i> <?php echo ossn_print('wallet:admin:overview');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ossn_site_url("administrator/component/Wallet?page=gateways");?>"><i class="fa-solid fa-gear"></i> <?php echo ossn_print('wallet:admin:gateways');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ossn_site_url("administrator/component/Wallet?page=tax");?>"><i class="fas fa-gear"></i> <?php echo ossn_print('wallet:taxsettings');?></a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ossn_site_url("administrator/component/Wallet?page=blocked");?>"><i class="fa-solid fa-shield-halved"></i> <?php echo ossn_print('wallet:admin:blocked');?></a>
        </li>                                
      </ul>
    </div>
</nav>