import { BaseControl, Button, PanelBody, PanelRow, Placeholder, Spinner, ToggleControl } from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";

class App extends Component {
	state = {
		isAPILoaded: false,
		isAPISaving: false,
		analytics_key: "",
		analytics_status: false,
	};

	componentDidMount() {
		apiFetch({ path: plugin.apiPath }).then((settings) => {
			this.setState({
				analytics_key: settings.analytics_key,
				analytics_status: settings.analytics_status,
				isAPILoaded: true,
			});
		});
	}

	saveSettings() {
		this.setState({ isAPISaving: true });
		const data = {
			analytics_key: this.state.analytics_key,
			analytics_status: this.state.analytics_status,
		};
		apiFetch({ path: plugin.apiPath, method: "POST", parse: false, data }).then((res) => {
			this.setState({ isAPISaving: false });
		});
	}

	render() {
		if (!this.state.isAPILoaded) {
			return (
				<>
					<div className="header bg-white py-6 mb-4">
						<div className="container w-9/12 lg:w-7/12 mx-auto">
							<div className="flex items-center">
								<h1>{plugin.name}</h1>
								<div className="ml-3 text-xs rounded font-light bg-gray-200 px-1 border-gray-300">v{plugin.version}</div>
							</div>
						</div>
					</div>
					<div className="container w-9/12 lg:w-7/12 mx-auto flex items-center">
						<Placeholder>
							<Spinner />
						</Placeholder>
					</div>
				</>
			);
		}

		return (
			<>
				<div className="header bg-white py-6 mb-4">
					<div className="container w-9/12 lg:w-7/12 mx-auto">
						<div className="flex items-center">
							<h1>{plugin.name}</h1>
							<div className="ml-3 text-xs rounded font-light bg-gray-200 px-1 border-gray-300">v{plugin.version}</div>
						</div>
					</div>
				</div>

				<div className="container w-9/12 lg:w-7/12 mx-auto">
					<PanelBody title={__("Settings", "vnh_textdomain")} className="bg-white mb-4">
						<PanelRow>
							<BaseControl
								label={__("Google Analytics Key", "vnh_textdomain")}
								help={"In order to use Google Analytics, you need to use an API key."}
								id="options-google-analytics-api"
								className="text-field"
							>
								<input
									type="text"
									id="options-google-analytics-api"
									value={this.state.analytics_key}
									placeholder={__("Google Analytics API Key", "vnh_textdomain")}
									disabled={this.state.isAPISaving}
									onChange={(e) => this.setState({ analytics_key: e.target.value })}
								/>
							</BaseControl>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label={__("Track Admin Users?", "vnh_textdomain")}
								help={"Would you like to track views of logged-in admin accounts?."}
								checked={this.state.analytics_status}
								onChange={() => this.setState({ analytics_status: !this.state.analytics_status })}
							/>
						</PanelRow>
					</PanelBody>
					<Button isPrimary isLarge disabled={this.state.isAPISaving} onClick={() => this.saveSettings()}>
						{__("Save Settings", "vnh_textdomain")}
					</Button>
				</div>
			</>
		);
	}
}

export default App;
