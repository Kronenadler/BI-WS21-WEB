import { Component, OnInit } from '@angular/core';
import { Profile } from 'src/app/models/Profile';


@Component({
    selector: 'app-settings',
    templateUrl: './settings.component.html',
    styleUrls: ['./settings.component.css']
})
export class SettingsComponent implements OnInit {

    public profile: Profile; 

    public constructor() {
        this.profile = new Profile('', '', '', '', '');
    }

    public ngOnInit(): void {
    }

    public saveSettings(): void{

    }

    public cancelSettings(): void{

    }
}
