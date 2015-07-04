Name            : xLempCP
Summary         : Management system for LEMP web servers (Linux / Nginx / MySQL / PHP)
Version         : 0.1.0.%{BUILD_NUMBER}
Release         : 1
BuildArch       : noarch
Requires        : xLemp=0.1.0.%{BUILD_NUMBER}
# /usr/bin/xLemp
Prefix          : %{_datadir}/xLempCP

%define  _rpmfilename  %%{NAME}-%%{VERSION}-%%{RELEASE}.noarch.rpm
%define  USERNAME  xlemp

License         : GPA-3
Group           : Server Platform
Packager        : PoiXson <support@poixson.com>
URL             : http://poixson.com/

%description
Management system for LEMP web servers (Linux / Nginx / MySQL / PHP)



### Prep ###
%prep
# ensure xlemp user exists
if getent passwd "%{USERNAME}" >/dev/null ; then
	echo "Found existing user: %{USERNAME}"
else
	echo "User %{USERNAME} hasn't been created!"
	exit 1
fi
echo
echo



### Build ###
%build



### Install ###
%install
echo
echo "Install.."
# delete existing rpm's
%{__rm} -fv "%{_rpmdir}/%{name}-"*.noarch.rpm

# create directories
%{__install} -d -m 0755 \
	"${RPM_BUILD_ROOT}%{prefix}/" \
		|| exit 1

# copy xLempCP-x.x.x.x.tar.gz
%{__install} -m 400 \
	"%{SOURCE_ROOT}/target/%{name}-%{version}.tar.gz" \
	"${RPM_BUILD_ROOT}%{prefix}/" \
		|| exit 1



%clean
#if [ ! -z "%{_topdir}" ]; then
#	%{__rm} -rf --preserve-root "%{_topdir}" \
#		|| echo "Failed to delete build root (probably fine..)"
#fi



%post
# extract xLempCP-x.x.x.x.tar.gz to /usr/bin/xLemp/
pushd "%{prefix}/"
	tar -xvzf "%{name}-%{version}.tar.gz" \
		|| exit 1
popd



%preun
#%{__rm} -Rvf --preserve-root "%{prefix}/"



### Files ###
%files
%defattr(-,root,root,-)

"%{prefix}/%{name}-%{version}.tar.gz"
