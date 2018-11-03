<?php

class PluginSHistory_HookSHistory extends Hook {

	public function RegisterHook() {
		$this->AddHook('template_menu_settings_settings_item', 'profile',__CLASS__,-10);
	}

    public function profile() {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject_profile.tpl');
    }

}
?>