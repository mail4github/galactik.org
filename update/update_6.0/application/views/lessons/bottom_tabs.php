<ul class="nav nav-tabs ct-tabs-custom-one" role="tablist">
  <?php if(addon_status('forum')): ?>
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum-content" type="button" role="tab" aria-controls="forum-content" aria-selected="true">
        <?php echo get_phrase('Forum'); ?>
        <span></span>
      </button>
    </li>
  <?php endif ?>
  <?php if(addon_status('noticeboard')): ?>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="noticeboard-tab" data-bs-toggle="tab" data-bs-target="#noticeboard-content" type="button" role="tab" aria-controls="noticeboard-content" aria-selected="true">
        <?php echo get_phrase('Noticeboard'); ?>
        <span></span>
      </button>
    </li>
  <?php endif ?>
  <?php if(addon_status('assignment')): ?>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="assignment-tab" data-bs-toggle="tab" data-bs-target="#assignment-content" type="button" role="tab" aria-controls="assignment-content" aria-selected="true">
        <?php echo get_phrase('Assignment'); ?>
        <span></span>
      </button>
    </li>
  <?php endif ?>
  <?php if(addon_status('certificate')): ?>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="certificate-tab" data-bs-toggle="tab" data-bs-target="#certificate-content" type="button" role="tab" aria-controls="certificate-content" aria-selected="true">
        <?php echo get_phrase('Certificate'); ?>
        <span></span>
      </button>
    </li>
  <?php endif ?>
  <?php if(addon_status('live-class')): ?>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="live-class-tab" data-bs-toggle="tab" data-bs-target="#live-class-content" type="button" role="tab" aria-controls="live-class-content" aria-selected="true">
        <?php echo get_phrase('Live class'); ?>
        <span></span>
      </button>
    </li>
  <?php endif ?>
</ul>

<div class="tab-content ct-tabs-content">
  <div class="tab-pane fade show active" id="forum-content" role="tabpanel" aria-labelledby="forum-tab"></div>
  <div class="tab-pane fade" id="noticeboard-content" role="tabpanel" aria-labelledby="noticeboard-tab"></div>
  <div class="tab-pane fade" id="assignment-content" role="tabpanel" aria-labelledby="assignment-tab"></div>
  <div class="tab-pane fade" id="certificate-content" role="tabpanel" aria-labelledby="certificate-tab"></div>
  <div class="tab-pane fade" id="live-class-content" role="tabpanel" aria-labelledby="live-class-tab"></div>
</div>