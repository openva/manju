<?php

/*
 * Named for Manju Ganeriwala, Treasurer of Virginia
 *
 * TO DO
 * figure out why PHP crashes when Tidy is invoked
 *   test on a different server
 *   run Tidy at the command line
 * make the "output" directory
 * establish a variable to name the "output" directory, rather than hard-coding it
 * scan all files, generate a list of what's already been fetched, and don't re-fetch
 * provide a command-line switch to force re-fetching
 * distinguish between the inability to fetch a URL and the inability to parse it
*/

/*
 * Include the Simple HTML DOM Parser.
 */
include('simple_html_dom.php');

/*
 * Set the timezone, not because we care, but because otherwise PHP throws warnings.
 */
date_default_timezone_set("America/New_York");

/*
 * Create a list of every state agency.
 */
$agencies = array(
	189	=> 'Appropriation Vetoes—Operating',
	99	=> 'Attorney General—Division of Debt Collection',
	91	=> 'Attorney General and Department of Law',
	82	=> 'Auditor of Public Accounts',
	46	=> 'Augusta Correctional Center',
	449	=> 'Autism Advisory Council',
	65	=> 'Baskerville Correctional Center',
	203	=> 'Bland Correctional Center',
	31	=> 'Blue Ridge Community College',
	256	=> 'Board of Accountancy',
	259	=> 'Board of Bar Examiners',
	320	=> 'Board of Towing and Recovery Operators',
	323	=> 'Brown v. Board of Education Scholarship Awards Committee',
	213	=> 'Brunswick Correctional Center',
	264	=> 'Buckingham Correctional Center',
	112	=> 'Capital Square Preservation Council',
	208	=> 'Catawba Hospital',
	174	=> 'Central Appropriations—Capital Outlay',
	176	=> 'Central Appropriations—Debt Bonds 9(D)',
	175	=> 'Central Appropriations—Revenue Bonds 9(C)',
	197	=> 'Central Appropriations—Administration',
	64	=> 'Central Region Correctional Field Units',
	137	=> 'Central State Hospital',
	32	=> 'Central Virginia Community College',
	149	=> 'Central Virginia Training Center',
	123	=> 'Chesapeake Bay Commission',
	78	=> 'Chesapeake Bay Local Assistance Department',
	49	=> 'Chippokes Plantation Farm Foundation',
	271	=> 'Christopher Newport University',
	43	=> 'Circuit Courts',
	117	=> 'Citizen Advisory Commission—Executive Mansion',
	200	=> 'City and County Treasurers',
	86	=> 'Coffeewood Correctional Center',
	52	=> 'Combined District Courts',
	430	=> 'Commission on Civics Education',
	363	=> 'Commission on Electric Utility Restructuring',
	290	=> 'Commission on Local Government',
	366	=> 'Commission on Prevention of Human Trafficking',
	325	=> 'Commission on Unemployment Compensation',
	89	=> 'Commission on Virginia Alcohol Safety Action Program',
	100	=> 'Commissioners for Promotion of Uniformity of Legislation',
	177	=> 'Commonwealth Attorneys’ Services Council',
	103	=> 'Commonwealth Center for Behavioral Rehabilitation',
	156	=> 'Commonwealth Center for Children and Adolescents',
	154	=> 'Commonwealth Competition Council',
	109	=> 'Commonwealth Employees Health Insurance Fund',
	133	=> 'Compensation Board',
	227	=> 'Comprehensive Services for At-Risk Youth and Families',
	260	=> 'Cooperative Extension and Agricultural Research Service',
	59	=> 'Corrections—Division of Institutions',
	70	=> 'Court of Appeals of Virginia',
	28	=> 'Dabney S. Lancaster Community College',
	21	=> 'Danville Community College',
	44	=> 'Deep Meadow Correctional Center',
	45	=> 'Deerfield Correctional Center',
	145	=> 'Department for The Aging',
	6	=> 'Department for The Deaf and Hard-of-Hearing',
	288	=> 'Department for The Rights of Virginians With Disabilities',
	119	=> 'Department of Accounts',
	284	=> 'Department of Accounts Transfer Payments',
	199	=> 'Department of Accounts—Statewide Activities',
	40	=> 'Department of Agriculture and Consumer Services',
	230	=> 'Department of Alcoholic Beverage Control',
	122	=> 'Department of Aviation',
	57	=> 'Department of Business Assistance',
	166	=> 'Department of Charitable Gaming',
	226	=> 'Department of Conservation and Recreation',
	5	=> 'Department of Correctional Education',
	235	=> 'Department of Corrections—Employee Relations and Training',
	111	=> 'Department of Corrections, Central Activities',
	110	=> 'Department of Corrections, Division of Institutions',
	129	=> 'Department of Corrections—Central Administration',
	90	=> 'Department of Criminal Justice Services',
	228	=> 'Department of Education—Central Office Operations',
	225	=> 'Department of Education—Direct Aid To Public Education',
	71	=> 'Department of Emergency Management',
	182	=> 'Department of Employment Dispute Resolution',
	104	=> 'Department of Environmental Quality',
	178	=> 'Department of Fire Programs',
	301	=> 'Department of Forensic Science',
	88	=> 'Department of Forestry',
	69	=> 'Department of Game and Inland Fisheries',
	224	=> 'Department of General Services',
	115	=> 'Department of Health',
	255	=> 'Department of Health Professions',
	97	=> 'Department of Historic Resources',
	146	=> 'Department of Housing and Community Development',
	72	=> 'Department of Human Resource Management',
	282	=> 'Department of Information Technology',
	94	=> 'Department of Juvenile Justice',
	179	=> 'Department of Labor and Industry',
	127	=> 'Department of Medical Assistance Services',
	63	=> 'Department of Military Affairs',
	87	=> 'Department of Mines, Minerals and Energy',
	258	=> 'Department of Minority Business Enterprise',
	361	=> 'Department of Minority Business Enterprise',
	124	=> 'Department of Motor Vehicles',
	372	=> 'Department of Motor Vehicles Transfer Payment',
	407	=> 'Department of Motor Vehicles Transfer Payment',
	62	=> 'Department of Planning and Budget',
	254	=> 'Department of Professional and Occupational Regulation',
	113	=> 'Department of Rail and Public Transportation',
	277	=> 'Department of Rehabilitative Services',
	66	=> 'Department of Social Services',
	126	=> 'Department of State Police',
	144	=> 'Department of Taxation',
	281	=> 'Department of Technology Planning',
	283	=> 'Department of The State Internal Auditor',
	120	=> 'Department of The Treasury',
	198	=> 'Department of The Treasury—Statewide Activities',
	106	=> 'Department of Transportation',
	196	=> 'Department of Treasury—Trust Funds',
	292	=> 'Department of Veterans Affairs',
	160	=> 'Department of Veterans Services',
	360	=> 'Department of Veterans Services',
	406	=> 'Dept. of Behavioral Health and Developmental Services',
	205	=> 'Dept. of Mental Health, Mental Retardation and Substance Abu',
	80	=> 'Dillwyn Correctional Center',
	302	=> 'Disability Commission',
	181	=> 'Division of Capitol Police',
	74	=> 'Division of Community Corrections',
	19	=> 'Division of Legislative Automated Systems',
	14	=> 'Division of Legislative Services',
	95	=> 'Dmhmrsas—Grants To Localities',
	131	=> 'Dr. Martin Luther King Memorial Commission',
	25	=> 'Eastern Shore Community College',
	138	=> 'Eastern State Hospital',
	11	=> 'Eastern Virginia Medical School',
	410	=> 'Economic Development Incentive Payments',
	326	=> 'Enterprise Application Public—Private Partner Prj',
	239	=> 'Fluvanna Women’s Correctional Center',
	269	=> 'Frontier Culture Museum of Virginia',
	50	=> 'General District Courts',
	274	=> 'George Mason University',
	37	=> 'Germanna Community College',
	151	=> 'Governors Commission on Government Finance Reform for The 21',
	409	=> 'Grayson County Correctional Center',
	322	=> 'Green Rock Correctional Center',
	79	=> 'Greensville Correctional Center',
	96	=> 'Gunston Hall',
	85	=> 'Haynesville Correctional Center',
	152	=> 'Health and Human Resources Capital Clearing Account',
	305	=> 'Higher Education Research Initiative',
	374	=> 'Higher Education Tuition Moderation Incentive',
	263	=> 'Hiram W. Davis Medical Center',
	2	=> 'House of Delegates',
	155	=> 'Human Rights Council',
	84	=> 'Indian Creek Correctional Center',
	397	=> 'Innovation and Entreprenuership Investment Authority',
	162	=> 'Innovative Technology Authority',
	291	=> 'Institute for Advanced Learning and Research',
	161	=> 'Interstate Organization Contributions',
	24	=> 'J. Sargeant Reynolds Community College',
	248	=> 'James Madison University',
	204	=> 'James River Correctional Center',
	67	=> 'Jamestown 2007',
	98	=> 'Jamestown-Yorktown Foundation',
	398	=> 'Jefferson Science Associates, Llc',
	30	=> 'John Tyler Community College',
	365	=> 'Joint Commission on Administrative Rules',
	130	=> 'Joint Commission on Health Care',
	132	=> 'Joint Commission on Technology and Science',
	20	=> 'Joint Legislative Audit and Review Commission',
	9	=> 'Judicial Department Reversion Clearing Account',
	42	=> 'Judicial Inquiry and Review Commission',
	51	=> 'Juvenile and Domestic Relations District Courts',
	75	=> 'Keen Mountain Correctional Center',
	7	=> 'Legislative Department Reversion Clearing Account',
	55	=> 'Lieutenant Governor',
	246	=> 'Longwood University',
	38	=> 'Lord Fairfax Community College',
	93	=> 'Lunenburg Correctional Center',
	8	=> 'Magistrate System',
	364	=> 'Manufacturing Development Commission',
	68	=> 'Marine Resources Commission',
	262	=> 'Marion Correctional Treatment Center',
	240	=> 'Mecklenburg Correctional Center',
	252	=> 'Melchers-Monroe Memorials—Mary Washington College',
	101	=> 'Mental Health Treatment Centers',
	102	=> 'Mental Retardation Training Centers',
	286	=> 'Milk Commission',
	114	=> 'Motor Vehicle Dealer Board',
	39	=> 'Mountain Empire Community College',
	304	=> 'New College Institute',
	12	=> 'New River Community College',
	188	=> 'Nonstate Agencies',
	245	=> 'Norfolk State University',
	287	=> 'Northern Region Correctional Field Units',
	22	=> 'Northern Virginia Community College',
	211	=> 'Northern Virginia Mental Health Institute',
	209	=> 'Northern Virginia Training Center',
	261	=> 'Nottoway Correctional Center',
	143	=> 'Office for Substance Abuse Prevention',
	105	=> 'Office of Commonwealth Preparedness',
	300	=> 'Office of Inspector General Mental Health',
	61	=> 'Office of The Governor',
	469	=> 'Office of The State Inspector General',
	253	=> 'Old Dominion University',
	26	=> 'Patrick Henry Community College',
	17	=> 'Paul D. Camp Community College',
	140	=> 'Personal Property Tax Relief Act',
	212	=> 'Piedmont Geriatric Hospital',
	23	=> 'Piedmont Virginia Community College',
	194	=> 'Planned Reversions',
	321	=> 'Pocahontas State Correctional Center',
	157	=> 'Powhatan Correctional Center',
	206	=> 'Powhatan Reception and Classification Center',
	299	=> 'Private College Or University',
	139	=> 'Public Defender Commission',
	159	=> 'Public Safety Capital Clearing Account',
	249	=> 'Radford University',
	18	=> 'Rappahannock Community College',
	234	=> 'Red Onion State Prison',
	270	=> 'Richard Bland College',
	163	=> 'Roanoke Higher Education Authority',
	172	=> 'Secretary of Administration',
	285	=> 'Secretary of Agriculture and Forestry',
	223	=> 'Secretary of Commerce and Trade',
	186	=> 'Secretary of Education',
	221	=> 'Secretary of Finance',
	192	=> 'Secretary of Health and Human Resources',
	184	=> 'Secretary of Natural Resources',
	191	=> 'Secretary of Public Safety',
	185	=> 'Secretary of Technology',
	153	=> 'Secretary of The Commonwealth',
	190	=> 'Secretary of Transportation',
	1	=> 'Senate',
	370	=> 'Sitter-Barfoot Veterans Care Center',
	362	=> 'Small Business Commission',
	202	=> 'Southampton Correctional Center',
	233	=> 'Southampton Reception and Classification Center',
	327	=> 'Southampton Work Center',
	167	=> 'Southeastern University Research Association, Inc.',
	207	=> 'Southeastern Virginia Training Center',
	303	=> 'Southern Virginia Higher Education Center',
	220	=> 'Southern Virginia Mental Health Institute',
	16	=> 'Southside Virginia Community College',
	210	=> 'Southside Virginia Training Center',
	34	=> 'Southwest Virginia Community College',
	173	=> 'Southwest Virginia Higher Education Center',
	147	=> 'Southwestern Virginia Mental Health Institute',
	219	=> 'Southwestern Virginia Training Center',
	218	=> 'St. Brides Correctional Center',
	81	=> 'State Board of Elections',
	164	=> 'State Corporation Commission',
	272	=> 'State Council of Higher Education for Virginia',
	165	=> 'State Lottery Department',
	187	=> 'State Water Commission',
	214	=> 'Staunton Correctional Center',
	41	=> 'Supreme Court',
	215	=> 'Sussex I State Prison',
	216	=> 'Sussex Ii State Prison',
	237	=> 'The College of William and Mary In Virginia',
	229	=> 'The Library of Virginia',
	107	=> 'The Science Museum of Virginia',
	33	=> 'Thomas Nelson Community College',
	35	=> 'Tidewater Community College',
	141	=> 'Tobacco Indemnification and Revitalization Commission',
	125	=> 'Treasury Board',
	195	=> 'Treasury Construction Financing',
	193	=> 'Unconstitutional Appropriations',
	247	=> 'University of Mary Washington',
	273	=> 'University of Virginia—College At Wise',
	242	=> 'University of Virginia Medical Center',
	238	=> 'University of Virginia—Academic Division',
	373	=> 'Va Bicentennial of American War of 1812',
	429	=> 'Va Comm Centennial of The Woodrow Wilson Presidency',
	47	=> 'Virginia Agricultural Council',
	150	=> 'Virginia Baseball Stadium Authority',
	128	=> 'Virginia Board for People With Disabilities',
	54	=> 'Virginia Coal and Energy Commission',
	15	=> 'Virginia Code Commission',
	168	=> 'Virginia College Building Authority',
	170	=> 'Virginia College Savings Plan',
	108	=> 'Virginia Commission for The Arts',
	408	=> 'Virginia Commission on Energy and Environment',
	13	=> 'Virginia Commission on Intergovernmental Cooperation',
	118	=> 'Virginia Commission on Youth',
	267	=> 'Virginia Commonwealth University—Academic Division',
	275	=> 'Virginia Community College System',
	10	=> 'Virginia Community College System—Utility',
	276	=> 'Virginia Community College System—System Office',
	201	=> 'Virginia Correctional Center for Women',
	158	=> 'Virginia Correctional Enterprises',
	92	=> 'Virginia Crime Commission',
	135	=> 'Virginia Criminal Sentencing Commission',
	136	=> 'Virginia Department for The Blind and Vision Impaired',
	48	=> 'Virginia Economic Development Partnership',
	180	=> 'Virginia Employment Commission',
	116	=> 'Virginia Freedom of Information Advisory Council',
	36	=> 'Virginia Highlands Community College',
	121	=> 'Virginia Housing Study Commission',
	280	=> 'Virginia Information Providers Network Authority',
	83	=> 'Virginia Information Technologies Agency',
	4	=> 'Virginia Institute of Marine Science',
	183	=> 'Virginia Liaison Office',
	243	=> 'Virginia Military Institute',
	268	=> 'Virginia Museum of Fine Arts',
	169	=> 'Virginia Museum of Natural History',
	375	=> 'Virginia National Defense Industrial Authority',
	171	=> 'Virginia Office for Protection and Advocacy',
	73	=> 'Virginia Parole Board',
	241	=> 'Virginia Polytechnic Institute and State University',
	257	=> 'Virginia Polytechnic Institute and State University, Va Coop',
	77	=> 'Virginia Port Authority',
	289	=> 'Virginia Public Broadcasting Board',
	76	=> 'Virginia Racing Commission',
	3	=> 'Virginia Rehabilitation Center for The Blind and Vision Impa',
	134	=> 'Virginia Retirement System',
	250	=> 'Virginia School for Deaf and Blind At Staunton',
	251	=> 'Virginia School for Deaf, Blind and Multi-Disabled at Hampton',
	324	=> 'Virginia Sesquicentennial American Civil War Commission',
	53	=> 'Virginia State Bar',
	244	=> 'Virginia State University',
	142	=> 'Virginia Tobacco Settlement Foundation',
	56	=> 'Virginia Tourism Authority',
	371	=> 'Virginia Veterans Care Center',
	279	=> 'Virginia Veterans Care Center Board of Trustees',
	27	=> 'Virginia Western Community College',
	222	=> 'Virginia Workers’ Compensation Commission',
	58	=> 'Virginia-Israel Advisory Board',
	217	=> 'Wallens Ridge State Prison',
	60	=> 'Western Region Correctional Field Units',
	148	=> 'Western State Hospital',
	236	=> 'Woodrow Wilson Rehabilitation Center',
	340	=> 'Workforce Development Agency',
	29	=> 'Wytheville Community College');
$agencies = (object) $agencies;

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);


/*
 * Iterate through every known agency.
 */
foreach ($agencies as $id => $agency_name)
{
	
	/*
	 * Iterate through every year for which data exists. (The site's records start in 2009.)
	 */
	for ($year = 2009; $year <= date('Y'); $year++)
	{
	
		/*
		 * Fetch the HTML for this agency checkbook for this year.
		 */
		$url = 'http://datapoint.apa.virginia.gov/exp/exp_checkbook_voucher.cfm?FY=' . $year . '&AGY=' . $id;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'Export=Export+Vouchers');
		$html = curl_exec($ch);
		
		echo 'Fetching ' . $url . PHP_EOL;
		
		if ($html === FALSE)
		{
			echo 'Could not retrieve ' . $url . PHP_EOL;
			continue;
		}
		
		file_put_contents('tmp.html', $html);
		exec('tidy -q tmp.html', $html);
		$html = implode('', $html);
		unlink('tmp.html');
		
		/*
		 * Convert the HTML into an object.
		 */
		$html = str_get_html($tidy);
		
		if ($html === FALSE)
		{
			echo 'Could not parse ' . $url . PHP_EOL;
			continue;
		}
		
		/*
		 * Initialize an array to store our table of data.
		 */
		$table = array();
		
		/*
		 * Iterate through the rows, extract them, and append them to our table.
		 */
		foreach ($html->find('tr') as $row)
		{
			
			$row_data = array();
			
			foreach ($row->find('td') as $cell)
			{
				$row_data[] = trim(strip_tags($cell->innertext));
			}
			
			$table[] = $row_data;
		}
		
		/*
		 * If there are two or fewer rows in this table, then don't bother.
		 */
		if (count($table) <= 2)
		{
			continue;
		}

// classify expenses by type (see <http://datapoint.apa.virginia.gov/search.cfm>)

		/*
		 * We now have an entire table's data as an object.
		 */
		$json = json_encode($table);
		file_put_contents('output/' . $id . '-' . $year . '.json', $json);
	}
}

curl_close($ch);
