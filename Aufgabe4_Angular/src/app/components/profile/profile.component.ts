import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Profile } from 'src/app/models/Profile';
import { User } from 'src/app/models/User';
import { BackendService } from 'src/app/services/backend.service';


@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
    
    public profile: Profile = new Profile('', '', '', '', '');
    profileUser: User = new User();

    header: string = '';

    public constructor(public router: Router, private backendservice: BackendService) { 
    }

    public ngOnInit(): void {
        // TODO: Namen ändern
        this.backendservice.loadUser('David').then((user: any) => {
            this.profileUser = user != null ? user : new User();
            this.profile.firstName = user != null ? user.firstName : '';
            this.profile.lastName = user != null ? user.lastName : '';
            this.profile.coffeeOrTea = user != null ? user.coffeeOrTea : '';
            this.profile.description = user != null ? user.description : '';
            this.profile.layout = user != null ? user.layout : '';
        }).finally(() => {
            this.header = 'Profil von ' + this.profileUser.username;
        })
    }

    public removeFriend(): void{
        this.backendservice.removeFriend(this.profileUser.username)
        .then((result) => {
            if (result) {
                this.router.navigate(['/friends']);
            }
            else{
                console.log("Fehler beim Speichern des Profils");
            }
        })
    }

}
