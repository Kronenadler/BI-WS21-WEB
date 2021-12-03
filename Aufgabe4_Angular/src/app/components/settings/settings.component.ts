import { Component, OnInit } from '@angular/core';
import { Profile } from 'src/app/models/Profile';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';


@Component({
    selector: 'app-settings',
    templateUrl: './settings.component.html',
    styleUrls: ['./settings.component.css']
})
export class SettingsComponent implements OnInit {

    public profile: Profile = new Profile('', '', '', '', '');

    public constructor(public router: Router, private backendservice: BackendService) {
    }

    public ngOnInit(): void {
        this.backendservice.loadCurrentUser().then((user: any) => {
            this.profile.firstName = user != null ? user.firstName : '';
            this.profile.lastName = user != null ? user.lastName : '';
            this.profile.coffeeOrTea = user != null ? user.coffeeOrTea : '';
            this.profile.description = user != null ? user.description : '';
            this.profile.layout = user != null ? user.layout : '';
        })
    }

    public saveSettings(): void{
        this.backendservice.saveCurrentUserProfile(this.profile)
        .then((result) => {
            if (result) {
                this.router.navigate(['/friends']);
            }
            else{
                console.log("Fehler beim Speichern des Profils");
            }
        })
    }

    public cancelSettings(): void{
        this.router.navigate(['/friends']);
    }
}
